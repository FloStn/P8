<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use AppBundle\Handler\Form\TaskFormHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class TaskController extends Controller
{
    /**
     * @Route("/tasks", name="task_list", methods="GET")
     *
     * @return RedirectResponse|Response
     */
    public function listAction(EntityManagerInterface $entityManager)
    {
        $repository = $entityManager->getRepository(Task::class);
        $author = $this->getUser();
        $tasks = $repository->findByAuthorField($author);

        return $this->render(
            'task/list.html.twig', [
            'tasks' => $tasks,
            ]
        );
    }

    /**
     * @Route("/tasks/create", name="task_create", methods={"GET", "POST"})
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request, TaskFormHandler $taskFormHandler)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $user = $this->getUser();

        $form->handleRequest($request);

        if ($taskFormHandler->createFormHandler($user, $task, $form)) {
            $this->addFlash('success', 'La tâche a bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @IsGranted("edit",         subject="task")
     * @Route("/tasks/{id}/edit", name="task_edit", methods={"GET", "POST"})
     *
     * @param Task    $task
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Task $task, Request $request, TaskFormHandler $taskFormHandler)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($taskFormHandler->editFormHandler($form)) {
            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render(
            'task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
            ]
        );
    }

    /**
     * @IsGranted("edit",           subject="task")
     * @Route("/tasks/{id}/toggle", name="task_toggle", methods="GET")
     *
     * @param Task $task
     *
     * @return RedirectResponse|Response
     */
    public function toggleTaskAction(Task $task, EntityManagerInterface $entityManager)
    {
        $task->toggle(!$task->isDone());
        $entityManager->flush();

        if ($task->isDone()) {
            $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));
        }
        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme non terminée.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @IsGranted("delete",         subject="task")
     * @Route("/tasks/{id}/delete", name="task_delete", methods="GET")
     *
     * @param Task $task
     *
     * @return RedirectResponse|Response
     */
    public function deleteTaskAction(Task $task, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($task);
        $entityManager->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
