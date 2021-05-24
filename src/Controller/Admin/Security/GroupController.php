<?php

/**
 * @Author: Gallarian <gallarian@gmail.com>
 */

namespace App\Controller\Admin\Security;

use App\Entity\Security\Group;
use App\Form\Admin\Security\GroupType;
use App\Service\ErrorFlushService;
use App\Service\LoggerService;
use App\Service\RedirectWithFlashMessageService;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/administration/groupes", name="admin_group_")
 */
class GroupController extends AbstractController
{
    /**
     * @Route(name="list", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render("admin/views/security/group/index.html.twig", [
            "groups" => $this->getDoctrine()->getRepository(Group::class)->findBy([], ["createdAt" => "ASC"])
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"}, priority=-10)
     */
    public function show(Group $group): Response
    {
        return $this->render("admin/views/security/group/show.html.twig", compact("group"));
    }

    /**
     * @Route("/creation", name="create", methods={"GET", "POST"})
     */
    public function create(
        LoggerService $loggerService,
        Request $request,
        SluggerInterface $slugger,
        TranslatorInterface $translator
    ): Response {
        $group = new Group();
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $group->setSlug($slugger->slug($form->get("name")->getData())->lower());

            $this->getDoctrine()->getManager()->persist($group);

            try {
                $this->getDoctrine()->getManager()->flush();
            } catch (Exception $e) {
                $loggerService->log("group", "create", "error", $translator->trans("error.flush"), $e->getMessage());

                $this->addFlash("error", $translator->trans("error.flush"));

                return $this->redirectToRoute("admin_group_create");
            }

            $this->addFlash("success", $translator->trans("group.success.create"));

            return $this->redirectToRoute("admin_group_list");
        }

        return $this->render("admin/views/security/group/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/mise-a-jour/{id}", name="update", methods={"GET", "PATCH"})
     */
    public function update(
        Group $group,
        LoggerService $loggerService,
        Request $request,
        SluggerInterface $slugger,
        TranslatorInterface $translator
    ): Response {
        $form = $this->createForm(GroupType::class, $group, ["edit" => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!array_key_exists("isActivate", $request->request->get("group"))) {
                $group->setIsActivate(false);
            }

            $group->setUpdatedAt(["user" => "user", "date" => new DateTime()]);
            $group->setSlug($slugger->slug($form->get("name")->getData())->lower());

            try {
                $this->getDoctrine()->getManager()->flush();
            } catch (Exception $e) {
                $loggerService->log("group", "update", "error", $translator->trans("error.flush"), $e->getMessage());

                $this->addFlash("error", $translator->trans("error.flush"));

                return $this->redirectToRoute("admin_group_update");
            }

            $this->addFlash("success", $translator->trans("group.success.update"));

            return $this->redirectToRoute("admin_group_list");
        }

        return $this->render("admin/views/security/group/update.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/activation/{id}", name="activate", methods={"PATCH"})
     */
    public function activate(
        Group $group,
        LoggerService $loggerService,
        Request $request,
        TranslatorInterface $translator
    ): Response {
        if (
            !$this->isCsrfTokenValid(
                "admin-group-activate-{$group->getId()}",
                $request->request->get("_token")
            )
        ) {
            $this->addFlash(
                "danger",
                $translator->trans("group.activate.token.error", ["name" => $group->getName()])
            );

            return $this->redirectToRoute("admin_group_list");
        }

        $group->setIsActivate(true)->setUpdatedAt(["user" => "user", "date" => new DateTime()]);

        try {
            $this->getDoctrine()->getManager()->flush();
        } catch (Exception $e) {
            $loggerService->log("group", "activate", "error", $translator->trans("error.flush"), $e->getMessage());

            $this->addFlash("error", $translator->trans("error.flush"));

            return $this->redirectToRoute("admin_group_list");
        }

        $this->addFlash(
            "success",
            $translator->trans("group.success.activate", ["name" => $group->getName()])
        );

        return $this->redirectToRoute("admin_group_list");
    }

    /**
     * @Route("/desactivation/{id}", name="deactivate", methods={"PATCH"})
     */
    public function deactivate(
        Group $group,
        LoggerService $loggerService,
        Request $request,
        TranslatorInterface $translator
    ): Response {
        if (
            !$this->isCsrfTokenValid(
                "admin-group-deactivate-{$group->getId()}",
                $request->request->get("_token")
            )
        ) {
            $this->addFlash(
                "danger",
                $translator->trans("group.deactivate.token.error", ["name" => $group->getName()])
            );

            return $this->redirectToRoute("admin_group_list");
        }

        $group->setIsActivate(false)->setUpdatedAt(["user" => "user", "date" => new DateTime()]);

        try {
            $this->getDoctrine()->getManager()->flush();
        } catch (Exception $e) {
            $loggerService->log("group", "deactivate", "error", $translator->trans("error.flush"), $e->getMessage());

            $this->addFlash("error", $translator->trans("error.flush"));

            return $this->redirectToRoute("admin_group_list");
        }


        $this->addFlash(
            "success",
            $translator->trans("group.success.deactivate", ["name" => $group->getName()])
        );

        return $this->redirectToRoute("admin_group_list");
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(
        Group $group,
        LoggerService $loggerService,
        Request $request,
        TranslatorInterface $translator
    ): Response {
        if (
            !$this->isCsrfTokenValid(
                "admin-group-delete-{$group->getId()}",
                $request->request->get("_token")
            )
        ) {
            $this->addFlash(
                "danger",
                $translator->trans("group.delete.token.error", ["name" => $group->getName()])
            );

            return $this->redirectToRoute("admin_group_list");
        }

        $this->getDoctrine()->getManager()->remove($group);

        try {
            $this->getDoctrine()->getManager()->flush();
        } catch (Exception $e) {
            $loggerService->log("group", "delete", "error", $translator->trans("error.flush"), $e->getMessage());

            $this->addFlash("error", $translator->trans("error.flush"));

            return $this->redirectToRoute("admin_group_list");
        }

        $this->addFlash(
            "success",
            $translator->trans("group.success.delete", ["name" => $group->getName()])
        );

        return $this->redirectToRoute("admin_group_list");
    }
}
