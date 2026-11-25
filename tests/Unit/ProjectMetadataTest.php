<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ProjectMetadataTest extends TestCase
{
    private function rootPath(string $relative = ''): string
    {
        $root = dirname(__DIR__, 2);
        return $relative === '' ? $root : $root . DIRECTORY_SEPARATOR . $relative;
    }

    public function test_version_file_exists_and_uses_semver(): void
    {
        $versionFile = $this->rootPath('VERSION');
        $this->assertFileExists($versionFile);

        $version = trim((string) file_get_contents($versionFile));
        $this->assertMatchesRegularExpression('/^\d+\.\d+\.\d+(?:-[0-9A-Za-z.-]+)?$/', $version);
    }

    public function test_changelog_and_citation_match_version(): void
    {
        $version = trim((string) file_get_contents($this->rootPath('VERSION')));

        $changelogPath = $this->rootPath('CHANGELOG.md');
        $this->assertFileExists($changelogPath);
        $changelog = (string) file_get_contents($changelogPath);
        $this->assertStringContainsString("## [{$version}] - ", $changelog);

        $citationPath = $this->rootPath('CITATION.cff');
        $this->assertFileExists($citationPath);
        $citation = (string) file_get_contents($citationPath);
        $this->assertStringContainsString("version: \"{$version}\"", $citation);
    }

    public function test_governance_markdown_has_no_em_dash(): void
    {
        $files = ['README.md', 'CHANGELOG.md', 'CONTRIBUTING.md', 'SECURITY.md'];
        foreach ($files as $file) {
            $path = $this->rootPath($file);
            $this->assertFileExists($path, "Missing governance file: {$file}");
            $content = (string) file_get_contents($path);
            $this->assertStringNotContainsString("\u{2014}", $content, "Em dash found in {$file}");
        }
    }

    public function test_readme_uses_absolute_links_and_images(): void
    {
        $readme = (string) file_get_contents($this->rootPath('README.md'));
        $this->assertDoesNotMatchRegularExpression('/\]\((?!https?:\/\/|#|mailto:)/', $readme);
        $this->assertDoesNotMatchRegularExpression('/src="(?!https?:\/\/)/', $readme);
    }
}
