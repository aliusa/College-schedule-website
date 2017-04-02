<?php

namespace App;

use App\Utils\DateUtils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


/**
 * Child of {@link RecurringTask}
 * @author Alius Sultanovas
 * @property int         $lecture_id        PK
 * @property integer     $recurring_task_id FK  {@link RecurringTask}
 * @property integer     $classroom_id      FK where lecture is  {@link Classroom}
 * @property string      $date              Date when lecture is
 * @property string      $time_start        lecture start time
 * @property string      $time_end          lecture end time
 * @property string      $duration          lecture duration. Virtual column TIMEDIFF(TimeEnd, TimeStart)
 * @property string      $weekday           virtual column (WEEKDAY(Date)+1)
 * @property string      $notes             lecture note for schedule
 * @property string      $topic             lecture topic
 * @property int         $is_canceled       if lecture is canceled
 * @property-read string $date_created      Date when lecture was created TIMESTAMP
 */
class Lecture extends Model
{
    public $timestamps = false;
    protected $table = 'lecture';
    protected $primaryKey = 'lecture_id';
    /**
     * The attributes that aren't mass assignable.
     * @var array
     */
    protected $guarded = ['lecture_id', 'date_created'];
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'recurring_task_id', 'classroom_id', 'date', 'time_start', 'time_end', 'notes', 'topic', 'is_canceled'
    ];

    /**
     * @param $id int LectureId
     * @return Lecture|null
     */
    public static function findById(int $id)
    {
        return self::all()->filter(function (Lecture $lecture) use ($id) {
            return intval($lecture->lecture_id) === $id;
        })->first();
    }

    /**
     * Find lectures from date interval. Accepted format <code>YYYY-mm-dd</code>
     * @param string $dateFrom  Date from which to get lectures
     * @param string $dateTo    Date to which to get lectures
     * @param bool   $inclusive include start/end dates
     * @return Collection
     * @throws \InvalidArgumentException Throws when input date from/to format is invalid
     */
    public static function findByInterval(string $dateFrom, string $dateTo, bool $inclusive = true)
    {
        // Check if date arguments are valid
        if (!DateUtils::isValid($dateFrom, $dateTo)) {
            throw new \InvalidArgumentException("Invalid date format provided Use YYYY-mm-dd.");
        }

        return self::all()
            ->filter(function (Lecture $lecture) use ($dateFrom, $dateTo, $inclusive) {
                if ($inclusive) {
                    return ($lecture->date >= $dateFrom) && ($lecture->date <= $dateTo);
                }

                return ($lecture->date > $dateFrom) && ($lecture->date < $dateTo);
            });
    }

    /**
     * @return Lecture
     */
    public static function getLast(): Lecture
    {
        return Lecture::all()->last();
    }

}
