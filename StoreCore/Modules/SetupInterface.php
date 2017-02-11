<?php
namespace StoreCore\Modules;

interface SetupInterface
{
    /**
     * Returns the module version.
     *
     * @param void
     *
     * @return string
     *   Semantic version (SemVer).
     */
    public function getVersion();

    /**
     * Installs a module.
     *
     * @param void
     *
     * @return bool
     *   Returns true on success and false on failure.
     */
    public function install();

    /**
     * Uninstalls a module.
     *
     * @param void
     *
     * @return bool
     *   Returns true on success and false on failure.
     */
    public function uninstall();
}
