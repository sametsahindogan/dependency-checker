<?php

namespace App\Services\GitService\Dependencies;

use App\Models\Dependency as DependencyModel;
use App\Services\GitService\GitResponse;

/**
 * Class FetchPackagist
 * @package App\Services\GitService\Dependencies
 */
class FetchPackagist implements Dependency
{
    /** @var array $packages */
    protected $packages = [];

    /** @var string $type */
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
     * FetchPackagist constructor.
     */
    public function __construct()
    {
        $this->type = DependencyModel::TYPE_PACKAGIST;
        $this->file = DependencyModel::FILE_PACKAGIST;
        $this->escapePackage = ['php'];
        $this->setEscapeChar = ['^', '-', '/', '~'];
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }

    /**
     * @param GitResponse $response
     * @return $this|bool|mixed
     */
    public function execute(GitResponse $response)
    {
        if (!$response->isSuccessful()) return $this;

        $content = $this->checkKey($response, 'require');

        if (!$content) return $this;

        foreach ($content as $package => $version) {

            if ((strpos($package, 'ext-') !== false)) continue;

            if (!(in_array($package, $this->escapePackage))) {
                $this->packages[$package] = $this->formatVersion($version);
            }
        }

        $this->saveDependencies();

        return $this;
    }

    /**
     * @param GitResponse $response
     * @param string $key
     * @return bool|mixed
     */
    public function checkKey(GitResponse $response, string $key)
    {
        $content = $this->getContent($response);

        if (isset($content[$key])) return $content[$key];

        return false;
    }

    /**
     * @param string $version
     * @return mixed
     */
    public function formatVersion(string $version)
    {
        return str_replace($this->escapeChar, '', $version);
    }

    /**
     * @param GitResponse $response
     * @return mixed
     */
    public function getContent(GitResponse $response)
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
     * @return bool
     */
    public function saveDependencies(): bool
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
