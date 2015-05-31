<?php

namespace Schedule\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Schedule\CMSBundle\Entity\Lecturer;
use Schedule\CMSBundle\Form\LecturerType;

/**
 * Lecturer controller.
 *
 * @Route("/lecturer")
 */
class LecturerController extends Controller
{

    /**
     * Lists all Lecturer entities.
     *
     * @Route("/", name="lecturer")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ScheduleCMSBundle:Lecturer')->findBy([],['lastname'=>'ASC']);

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Lecturer entity.
     *
     * @Route("/", name="lecturer_create")
     * @Method("POST")
     * @Template("ScheduleCMSBundle:Lecturer:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Lecturer();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lecturer_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Lecturer entity.
     *
     * @param Lecturer $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Lecturer $entity)
    {
        $form = $this->createForm(new LecturerType(), $entity, array(
            'action' => $this->generateUrl('lecturer_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Lecturer entity.
     *
     * @Route("/new", name="lecturer_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Lecturer();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Lecturer entity.
     *
     * @Route("/{id}", name="lecturer_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ScheduleCMSBundle:Lecturer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lecturer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Lecturer entity.
     *
     * @Route("/{id}/edit", name="lecturer_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ScheduleCMSBundle:Lecturer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lecturer entity.');
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
    * Creates a form to edit a Lecturer entity.
    *
    * @param Lecturer $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Lecturer $entity)
    {
        $form = $this->createForm(new LecturerType(), $entity, array(
            'action' => $this->generateUrl('lecturer_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Lecturer entity.
     *
     * @Route("/{id}", name="lecturer_update")
     * @Method("PUT")
     * @Template("ScheduleCMSBundle:Lecturer:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ScheduleCMSBundle:Lecturer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lecturer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('lecturer_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Lecturer entity.
     *
     * @Route("/{id}", name="lecturer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ScheduleCMSBundle:Lecturer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Lecturer entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('lecturer'));
    }

    /**
     * Creates a form to delete a Lecturer entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lecturer_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
