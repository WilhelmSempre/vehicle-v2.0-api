<?php
declare(strict_types=1);

namespace App\Services;

use Symfony\Component\HttpKernel\KernelInterface;

class GitService
{
    private string $projectDir;

    public function __construct(KernelInterface $kernel)
    {
        $this->projectDir = $kernel->getProjectDir();
    }

    private function getGitLogs(): array
    {
        chdir($this->projectDir);
        exec('git log',$gitConsoleData, $resultCode);

        var_dump($this->projectDir);

        $history = [];

        foreach($gitConsoleData as $line) {
            if (str_starts_with($line, 'commit')) {
                if (!empty($commit)) {
                    $history[] = $commit;
                    unset($commit);
                }

                $commit['hash'] = substr($line, strlen('commit'));
            } else if (str_starts_with($line, 'Author')) {
                $commit['author'] = substr($line, strlen('Author:'));
            } else if (str_starts_with($line, 'Date')) {
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

    public function getLastGitCommit(): ?array
    {
        $gitLogsArray = $this->getGitLogs();

        return array_shift($gitLogsArray);
    }

    public function loadGitSummary(): array
    {
        $branchName = $this->getBranchName();
        $lastGitCommit = $this->getLastGitCommit();

        if (!$lastGitCommit) {
            return [];
        }

        return [
            'branch' => $branchName,
            'commit_hash' => $lastGitCommit['hash'],
            'commit_message' => $lastGitCommit['message'],
            'commit_author' => $lastGitCommit['author'],
            'commit_date' => $lastGitCommit['date'],
        ];
    }

    private function getBranchName(): string
    {
        chdir($this->projectDir);
        exec('git rev-parse --abbrev-ref HEAD',$gitBranch);

        return $gitBranch[0] ?? 'Not detected';
    }
}
