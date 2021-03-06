<?php


class ModuleRepository
{
    /**
     * @var array
     */
    private $modules = [];

    /**
     * @param string $moduleName
     * @return Module
     */
    public function getModule($moduleName) : Module
    {
        if (!isset($this->modules[$moduleName])) {
            throw new RuntimeException(sprintf('No modules of type "%s" available.', $moduleName));
        }

        if (count($this->modules[$moduleName]) === 0) {
            throw new RuntimeException(sprintf('There is no Module "%s" on our List.', $moduleName));
        }

        return array_pop($this->modules[$moduleName]);
    }

    /**
     * @param Module $module
     */
    public function addModule(Module $module)
    {
        $this->modules[$module->getName()][] = $module;
    }
}