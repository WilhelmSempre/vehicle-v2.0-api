<?php

namespace App\Controller;

use App\Entity\GitSummary;
use App\Services\GitService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GitController
 * @package App\Controller
 */
class GitController extends AbstractController
{
    /**
     * @Route("/git/summary/{secret}", name="git_summary")
     * @param GitService $gitService
     * @param string $secret
     * @return Response
     */
    public function gitAction(GitService $gitService, string $secret): Response
    {
        $isSecretValid = $_ENV['APP_SECRET'] === $secret;

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

        $response = new Response();
        $response->setContent(serialize($gitSummary));

        return $response;
    }
}