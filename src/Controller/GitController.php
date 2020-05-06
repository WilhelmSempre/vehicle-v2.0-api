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
     * @Route("/git/summary", name="git_summary")
     * @param GitService $gitService
     * @return Response
     */
    public function gitAction(GitService $gitService): Response
    {
        $gitSummaryData = $gitService->loadGitSummary();

        $gitSummary = new GitSummary();

        var_dump($gitSummaryData);

        $gitSummary
            ->setBranchName($gitSummaryData['branch'])
            ->setLastCommitAuthor($gitSummaryData['commit_author'])
            ->setLastCommitDate($gitSummaryData['commit_date'])
            ->setLastCommitMessage($gitSummaryData['commit_message'])
        ;

        $response = new Response();
        $response->setContent(serialize($gitSummary));

        return $response;
    }
}