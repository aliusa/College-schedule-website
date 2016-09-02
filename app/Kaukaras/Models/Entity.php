<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016-05-05
 * Time: 22:43
 */

namespace Kaukaras\Models;


use Illuminate\Database\Eloquent\Model;

abstract class Entity extends Model
{
    /**
     * Overrides Model method. Formats query from given attributes and saves query to {@link LogAction}
     * Changed/Inserted attributes saved to {@link LogActionDetails}.
     * For method to work Model needs {@link getId()} method to be implemented.
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        // LogAction item
        $mLogAction = new LogAction();
        // Formatted query
        $str = null;
        $key_array = [];
        $value_array = [];
        // Array of LogActionDetails
        $mLogItem = [];
        // Boolean if Insert sql statement
        $mInsert = false;

        // item exist, so update
        if ($this->exists) {
            $mLogAction->action = 'update';
            $mLogAction->pk = $this->getId();

            foreach ($this->getAttributes() as $key => $value) {
                $original = $this->getOriginal($key);

                // Save to LogActionDetails only value which was edited
                if ($original != $value) {
                    $mLogDetails = new LogActionDetails();
                    $mLogDetails->Field = $key;
                    $mLogDetails->OldValue = $original;
                    $mLogDetails->NewValue = $value;
                    $mLogItem[] = $mLogDetails;

                    // For formatted query we need to write 'null'
                    if ($value == null) {
                        $value_array[] = 'null';
                    } else {
                        $valueFiltered = htmlspecialchars($value, ENT_QUOTES);
                        $value_array[] = sprintf("'%s'", $valueFiltered);
                    }

                    $key_array[] = $key;
                }


            }
            $temp = '';
            for ($i = 0; $i < sizeof($key_array); $i++) {
                $temp .= sprintf("%s=%s, ", $key_array[$i], $value_array[$i]);
            }
            // Format sql query
            $str = sprintf('UPDATE %s SET %s WHERE %s=%s',
                $this->getTable(),
                substr($temp, 0, -2),
                $this->primaryKey,
                $this->getId()
            );

        } else {
            $mLogAction->action = 'insert';
            // We don't have Primary Key yet, it'll be updated later.
            $mLogAction->pk = NULL;
            $mInsert = true;

            // Iterate each inserted value.
            foreach ($this->getAttributes() as $key => $value) {
                // Save key to array
                array_push($key_array, $key);

                if ($value == null) {
                    $value_array[] = 'null';
                } else {
                    $valueFiltered = htmlspecialchars($value, ENT_QUOTES);
                    $value_array[] = sprintf("'%s'", $valueFiltered);
                }

                if ($value != null && isNotEmptyOr($value, 0) != NULL) {
                    $mLogDetails = new LogActionDetails();
                    $mLogDetails->Field = $key;
                    $mLogDetails->OldValue = NULL;
                    $mLogDetails->NewValue = $value;
                    $mLogItem[] = $mLogDetails;
                }
            }

            // Format sql query
            $str = sprintf('INSERT INTO `%s` (%s) VALUES (%s);',
                $this->getTable(),
                implode(', ', $key_array),
                implode(', ', $value_array)
            );
        }

        $mLogAction->user()->associate($_SESSION['user_id']);
        $mLogAction->sql = $str;
        $mLogAction->tbl = $this->getTable();

        // Save item
        $msaved = parent::save($options);

        // Continue only if save was successful
        if ($msaved) {

            // Do not save LogAction if couldn't find any values. (eg: n:n tables)
            if (!empty($mLogItem)) {

                // Save LogAction
                $mlogactionsaved = $mLogAction->save();

                // Continue only if LogAction save was successful
                if ($mlogactionsaved) {

                    // If INSERT statement was usedsss
                    if ($mInsert) {
                        // Find last LogAction
                        $mLogActionSaved = LogAction::getLast();
                        // Find last inserted item and update LogAction PK column. Inserts 1 if not found.
                        $mLogActionSaved->pk = $this->getLastId() ?? 1;
                        $mLogActionSaved->save();
                    } else {
                        // Update. We don't have to do anything.
                    }

                    if (!empty($mLogItem)) {
                        // Iterate each item of LogActionDetails array
                        foreach ($mLogItem as $key => $value) {
                            $value->logAction()->associate(LogAction::getLastId());
                            $saved = $value->save();
                        }
                    }

                }
            }
        }
        return $msaved;
    }

    /**
     * @return int
     */
    public abstract function getId():int;

    public abstract function getLastId():int;

    public function delete()
    {
        // Array of LogActionDetails
        $mLogItem = [];

        $mLogAction = new LogAction();
        $mLogAction->action = 'delete';
        $mLogAction->pk = $this->getId();
        $mLogAction->user()->associate($_SESSION['user_id']);
        $mLogAction->tbl = $this->getTable();

        // Parse this item to array
        $json = json_decode($this, true);

        // Save each column name and value of this item to array.
        foreach ($json as $key => $value) {
            $mLogDetails = new LogActionDetails();
            $mLogDetails->Field = $key;
            $mLogDetails->OldValue = $value;
            $mLogDetails->NewValue = NULL;
            $mLogItem[] = $mLogDetails;
        }

        /*
                $myfile = fopen("testfile.txt", "a+") or die("Unable to open file!");
                file_put_contents('testfile.txt', print_r($json.'\n', true));
                fclose($myfile);*/

        $str = 'DELETE FROM `' . $this->getTable() . '` WHERE ' . $this->primaryKey . '=' . $this->getId();

        $mLogAction->sql = $str;

        // Delete original item
        $deleted = parent::delete();

        // Save LogAction/LogActionDetails only if delete was successful
        if ($deleted) {

            // Save LogAction
            $mlogactionsaved = $mLogAction->save();

            // Save LogActionDetails array only if LogAction save was successful
            if ($mlogactionsaved) {

                // Iterate each Log Action Details
                foreach ($mLogItem as $key => $value) {
                    $value->logAction()->associate(LogAction::getLastId());
                    $saved = $value->save();
                }

            }
        }

        return $deleted;
    }
}