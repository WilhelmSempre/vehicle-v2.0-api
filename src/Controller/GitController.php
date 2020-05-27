<?php

namespace App\Controller;

use App\Entity\GitSummary;
use App\Services\GitService;
use App\Services\AuthorizationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GitController
 * @package App\Controller
 */
class GitController extends AbstractController
{

    /**
     * @Route("/git/summary", name="git_summary", methods={"POST"})
     * @param Request $request
     * @param GitService $gitService
     * @param AuthorizationService $authorizationService
     * @return Response
     */
    public function gitAction(Request $request, GitService $gitService, AuthorizationService $authorizationService): Response
    {
        $response = new Response();

        $isSecretValid = $authorizationService->isSecretValid($request);

        if (!$isSecretValid) {
            return new Response();
        }

        $gitSummaryData = $gitService->loadGitSummary();

        $gitSummary = new GitSummary();

        $gitSummary
            ->setBranchName($gitSummaryData['branch'])
            ->setLastCommitAuthor($gitSummaryData['commit_author'])
            ->setLastCommitDate($gitSummaryData['commit_date'])
            ->setLastCommitMessage($gitSummaryData['commit_message'])
            ->setLastCommitHash($gitSummaryData['commit_hash'])
        ;

        $response->setStatusCode(Response::HTTP_OK);

        return $response->setContent(serialize($gitSummary));
    }
}