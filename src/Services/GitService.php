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
    private function getGitLogs(): array
    {
        chdir($this->projectDir);
        exec('git log',$gitConsoleData);

        $history = [];

        foreach($gitConsoleData as $line) {
            if (strpos($line, 'commit') === 0) {
                if (!empty($commit)) {
                    array_push($history, $commit);
                    unset($commit);
                }

                $commit['hash'] = substr($line, strlen('commit'));
            } else if (strpos($line, 'Author') === 0) {
                $commit['author'] = substr($line, strlen('Author:'));
            } else if(strpos($line, 'Date') === 0) {
                $commit['date'] = substr($line, strlen('Date:'));
            } else {
                if (isset($commit['message'])) {
                    $commit['message'] .= $line;
                } else {
                    $commit['message'] = $line;
                }
            }
        }

        return $history;
    }

    /**
     * @return array
     */
    public function getLastGitCommit(): array
    {
        $gitLogsArray = $this->getGitLogs();

        return array_shift($gitLogsArray);
    }

    /**
     * @return array
     */
    public function loadGitSummary(): array
    {
        $branchName = $this->getBranchName();
        $lastGitCommit = $this->getLastGitCommit();

        return [
            'branch' => $branchName,
            'commit_hash' => $lastGitCommit['hash'],
            'commit_message' => $lastGitCommit['message'],
            'commit_author' => $lastGitCommit['author'],
            'commit_date' => $lastGitCommit['date'],
        ];
    }

    /**
     * @return string
     */
    private function getBranchName(): string
    {
        chdir($this->projectDir);
        exec('git rev-parse --abbrev-ref HEAD',$gitBranch);

        return $gitBranch[0] ?? 'Not detected';
    }
}