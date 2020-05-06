<?php

namespace App\Services;

use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class GitService
 * @package App\Services
 */
class GitService
{

    /**
     * @var string
     */
    private $projectDir;

    /**
     * GitService constructor.
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->projectDir = $kernel->getProjectDir();
    }

    /**
     * @return array
     */
    public function loadGitSummary(): array
    {
        $branchName = $this->getBranchName();
        $lastCommitMessage = $this->getLastCommitMessage();
        $lastCommitDetails = $this->getLastCommitDetail();

        return [
            'branch' => $branchName,
            'commit_message' => $lastCommitMessage,
            'commit_author' => $lastCommitDetails['author'],
            'commit_date' => $lastCommitDetails['date'],
        ];
    }

    /**
     * @return string
     */
    private function getBranchName(): string
    {
        $gitHeadFile = sprintf('%s/.git/HEAD', $this->projectDir);

        $branchName = 'No branch name';

        $stringFromFile = file_exists($gitHeadFile) ? file($gitHeadFile, FILE_USE_INCLUDE_PATH) : '';

        if (isset($stringFromFile) && is_array($stringFromFile)) {
            $firstLine = $stringFromFile[0];
            $explodedString = explode('/', $firstLine, 3);

            $branchName = trim($explodedString[2]);
        }

        return $branchName;
    }

    /**
     * @return string
     */
    private function getLastCommitMessage(): string
    {
        $gitCommitMessageFile = sprintf('%s/.git/COMMIT_EDITMSG', $this->projectDir);
        $commitMessage = file_exists($gitCommitMessageFile) ? file($gitCommitMessageFile, FILE_USE_INCLUDE_PATH) : '';

        return is_array($commitMessage) ? trim($commitMessage[0]) : '';
    }

    /**
     * @return array
     */
    private function getLastCommitDetail(): array
    {
        $logs = [];

        $gitHeadFile = sprintf('%s/.git/HEAD', $this->projectDir);
        $gitLogs = file_exists($gitHeadFile) ? file($gitHeadFile, FILE_USE_INCLUDE_PATH) : '';

        $logExploded = explode(' ', end($gitLogs));
        $logs['author'] = $logExploded[2] ?? 'Not defined';
        $logs['date'] = isset($logExploded[4]) ? date('Y/m/d H:i', $logExploded[4]) : 'Not defined';

        return $logs;
    }
}