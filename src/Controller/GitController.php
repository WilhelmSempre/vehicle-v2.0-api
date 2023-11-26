<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\GitSummary;
use App\Services\GitService;
use App\Services\AuthorizationService;
use SodiumException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GitController extends AbstractController
{
    /**
     * @throws SodiumException
     */
    #[Route('/git/summary', name: 'git_summary', methods: ["POST", "GET"])]
    public function gitAction(
        Request $request,
        GitService $gitService,
        AuthorizationService $authorizationService
    ): Response {
        $response = new Response();

//        $isSecretValid = $authorizationService->isSecretValid($request);
//
//        if (!$isSecretValid) {
//            return new Response();
//        }

        $gitSummaryData = $gitService->loadGitSummary();

        $gitSummary = new GitSummary();

        $gitSummary
            ->setBranchName($gitSummaryData['branch'] ?? null)
            ->setLastCommitAuthor($gitSummaryData['commit_author'] ?? null)
            ->setLastCommitDate($gitSummaryData['commit_date'] ?? null)
            ->setLastCommitMessage($gitSummaryData['commit_message'] ?? null)
            ->setLastCommitHash($gitSummaryData['commit_hash'] ?? null)
        ;

        $response->setStatusCode(Response::HTTP_OK);

        return $response->setContent(serialize($gitSummary));
    }
}