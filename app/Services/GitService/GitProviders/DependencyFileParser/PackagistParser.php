<?php

namespace App\Services\GitService\GitProviders\DependencyFileParser;

use App\Models\Dependencies\Dependency as DependencyModel;
use App\Services\GitService\GitProviders\GitApiInterfaces\GitApiResponse;

/**
 * Class PackagistParser
 * @package App\Services\GitService\GitProviders\DependencyFileParser
 */
class PackagistParser implements DependencyParserInterface
{
    /** @var array $packages */
    protected $packages = [];

    /** @var int $type */
    protected $type;

    /** @var string $file */
    protected $file;

    /** @var array $escapePackage */
    protected $escapePackage = [];

    /** @var array $escapeChar */
    protected $escapeChar = [];

    /** @var array $dependencies */
    protected $dependencies = [];

    /**
     * PackagistParser constructor.
     */
    public function __construct()
    {
        $this->type = DependencyModel::TYPE_PACKAGIST;
        $this->file = DependencyModel::FILE_PACKAGIST;
        $this->escapePackage = ['php'];
        $this->escapeChar = ['^', '-', '/', '~'];
    }

    /**
     * @param GitApiResponse $response
     * @return DependencyParserInterface
     */
    public function execute(GitApiResponse $response): DependencyParserInterface
    {
        if (!$response->isSuccessful()) return $this;

        $content = $this->checkKey($response, 'require');

        foreach ($content as $package => $version) {

            if ((strpos($package, 'ext-') !== false)) continue;

            if (!(in_array($package, $this->escapePackage))) {
                $this->packages[$package] = $this->formatVersion($version);
            }
        }

        $this->setDependencies();

        return $this;
    }

    /**
     * @param GitApiResponse $response
     * @param string $key
     * @return array
     */
    public function checkKey(GitApiResponse $response, string $key): array
    {
        $content = $this->getContent($response);

        return isset($content[$key]) ? $content[$key] : [];
    }

    /**
     * @param string $version
     * @return string
     */
    public function formatVersion(string $version): string
    {
        return str_replace($this->escapeChar, '', $version);
    }

    /**
     * @param GitApiResponse $response
     * @return array
     */
    public function getContent(GitApiResponse $response): array
    {
        switch ($response->getEncodeType()) {
            case 'base64':
                $data = base64_decode($response->getFileContent());
                break;
            default:
                $data = json_encode($response->getFileContent());
                break;
        }

        return json_decode($data, true);
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return $this->dependencies;
    }

    /**
     * @return bool
     */
    public function setDependencies(): bool
    {
        foreach ($this->packages as $package => $version) {
            $this->dependencies[] = [
                'status' => DependencyModel::STATUS_CHECKING,
                'type_id' => $this->type,
                'title' => $package,
                'current_version' => $version
            ];
        }

        return true;
    }
}
