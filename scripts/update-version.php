<?php

/**
 * Script to check for latest PHP version and update the constant
 */

function getLatestPHPVersion(): ?string
{
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'timeout' => 10,
            'user_agent' => 'php-version-checker',
        ],
    ]);

    $response = @file_get_contents('https://www.php.net/releases/index.php?json&max=1', false, $context);
    
    if ($response === false) {
        echo "Error: Failed to fetch latest PHP version information\n";
        return null;
    }

    $data = json_decode($response, true);
    
    if (!$data || !isset($data['8']) || !isset($data['8']['version'])) {
        echo "Error: Invalid response format from PHP releases API\n";
        return null;
    }

    return $data['8']['version'];
}

function getCurrentVersionConstant(): ?string
{
    $versionFile = __DIR__ . '/../src/Version.php';
    
    if (!file_exists($versionFile)) {
        echo "Error: Version.php file not found\n";
        return null;
    }

    $content = file_get_contents($versionFile);
    
    if (preg_match('/public const LATEST_STABLE_VERSION = \'([^\']+)\';/', $content, $matches)) {
        return $matches[1];
    }

    echo "Error: Could not find LATEST_STABLE_VERSION constant\n";
    return null;
}

function updateVersionConstant(string $newVersion): bool
{
    $versionFile = __DIR__ . '/../src/Version.php';
    $content = file_get_contents($versionFile);
    
    $updatedContent = preg_replace(
        '/public const LATEST_STABLE_VERSION = \'[^\']+\';/',
        "public const LATEST_STABLE_VERSION = '$newVersion';",
        $content
    );

    if ($updatedContent === $content) {
        echo "Error: Failed to update version constant\n";
        return false;
    }

    if (file_put_contents($versionFile, $updatedContent) === false) {
        echo "Error: Failed to write updated content to file\n";
        return false;
    }

    return true;
}

function main(): int
{
    echo "Checking for latest PHP version...\n";
    
    $latestVersion = getLatestPHPVersion();
    if ($latestVersion === null) {
        return 1;
    }

    echo "Latest PHP version: $latestVersion\n";
    
    $currentVersion = getCurrentVersionConstant();
    if ($currentVersion === null) {
        return 1;
    }

    echo "Current version constant: $currentVersion\n";
    
    if ($latestVersion === $currentVersion) {
        echo "Version is already up to date!\n";
        return 0;
    }

    echo "New version detected! Updating constant...\n";
    
    if (!updateVersionConstant($latestVersion)) {
        return 1;
    }

    echo "Successfully updated version constant from $currentVersion to $latestVersion\n";
    
    // Set environment variable for GitHub Actions
    if (getenv('GITHUB_ACTIONS') === 'true') {
        file_put_contents(getenv('GITHUB_OUTPUT'), "version_updated=true\n", FILE_APPEND);
        file_put_contents(getenv('GITHUB_OUTPUT'), "old_version=$currentVersion\n", FILE_APPEND);
        file_put_contents(getenv('GITHUB_OUTPUT'), "new_version=$latestVersion\n", FILE_APPEND);
    }
    
    return 0;
}

exit(main()); 