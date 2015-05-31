<?php

namespace Schedule\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Schedule\CMSBundle\Entity\Faction;
use Schedule\CMSBundle\Form\FactionType;

/**
 * Faction controller.
 *
 * @Route("/faction")
 */
class FactionController extends Controller
{

    /**
     * Lists all Faction entities.
     *
     * @Route("/", name="faction")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ScheduleCMSBundle:Faction')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Faction entity.
     *
     * @Route("/", name="faction_create")
     * @Method("POST")
     * @Template("ScheduleCMSBundle:Faction:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Faction();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('faction_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Faction entity.
     *
     * @param Faction $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Faction $entity)
    {
        $form = $this->createForm(new FactionType(), $entity, array(
            'action' => $this->generateUrl('faction_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Faction entity.
     *
     * @Route("/new", name="faction_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Faction();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Faction entity.
     *
     * @Route("/{id}", name="faction_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ScheduleCMSBundle:Faction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Faction entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Faction entity.
     *
     * @Route("/{id}/edit", name="faction_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ScheduleCMSBundle:Faction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Faction entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Faction entity.
    *
    * @param Faction $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Faction $entity)
    {
        $form = $this->createForm(new FactionType(), $entity, array(
            'action' => $this->generateUrl('faction_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Faction entity.
     *
     * @Route("/{id}", name="faction_update")
     * @Method("PUT")
     * @Template("ScheduleCMSBundle:Faction:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ScheduleCMSBundle:Faction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Faction entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('faction_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Faction entity.
     *
     * @Route("/{id}", name="faction_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ScheduleCMSBundle:Faction')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Faction entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('faction'));
    }

    /**
     * Creates a form to delete a Faction entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('faction_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
