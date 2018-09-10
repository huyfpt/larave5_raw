<?php namespace Hegyd\Permissions\Support;

use Illuminate\Console\Command;

class HegydCommand extends Command
{

    protected $viewNamespace = 'hegyd-permissions';

    /**
     *
     * Generates the given file with the rendered view.
     *
     * @param string $filename Path to the file within the app directory.
     * @param string $view View file.
     * @param array $viewVars Variables that are going to be passed to the view.
     * @param bool $forceIfExists Erase the current content of file
     * @return bool
     */
    protected function generateFile($filename, $view, $viewVars, $forceIfExists = false)
    {
        $output = view($this->viewNamespace . '::' . $view, $viewVars)->render();
        $filename = trim($filename);

        if ( ! file_exists($filename) || $forceIfExists)
        {
            $directory = dirname($filename);
            $this->makeDir($directory, 0755, true);
            $this->filePutContents($filename, $output);

            return true;
        }

        return false;
    }

    /**
     * Append the rendered view to the given file. Same as generateFile but
     * the 'file_put_contents' is called with the FILE_APPEND flag.
     *
     * @param string $filename Path to the file within the app directory.
     * @param string $view View file.
     * @param array $viewVars Variables that are going to be passed to the view.
     *
     * @return bool Success.
     */
    protected function appendInFile($filename, $view, $viewVars)
    {
        $output = view($this->viewNamespace . '::' . $view, $viewVars)->render();
        $filename = trim($filename);
        $directory = dirname($filename);
        $this->makeDir($directory, 0755, true);
        $this->filePutContents($filename, $output, FILE_APPEND);

        return true;
    }

    /**
     * Encapsulates mkdir function.
     *
     * @codeCoverageIgnore
     *
     * @param string $directory
     * @param int $mode
     * @param bool $recursive
     *
     * @return void
     */
    protected function makeDir($directory, $mode, $recursive)
    {
        if ( ! is_dir($directory))
        {
            @mkdir($directory, $mode, $recursive);
        }
    }

    /**
     * Encapsulates file_put_contents function.
     *
     * @codeCoverageIgnore
     *
     * @param string $filename
     * @param string $data
     * @param int $flags
     *
     * @return void
     */
    protected function filePutContents($filename, $data, $flags = 0)
    {
        @file_put_contents($filename, $data, $flags);
    }


    /**
     * Returns the name of the resource class that will handle a
     * resource with the given name.
     *
     * @param string $name Resource name.
     *
     * @return string Resource class name.
     */
    protected function getResourceName($name, $default)
    {
        if (strstr($name, '\\'))
        {
            $name = explode('\\', $name);
            $name = array_pop($name);
        }
        $name = ($name != '') ? ucfirst($name) : ucfirst($default);

        return $name;
    }

    /**
     * Returns the namespace of the given class name.
     *
     * @param string $name Class name.
     *
     * @return string Namespace.
     */
    protected function getNamespace($name)
    {
        if (strstr($name, '\\'))
        {
            $name = explode('\\', $name);
            array_pop($name);
            $name = implode('\\', $name);
        } else
        {
            $name = '';
        }

        return $name;
    }

    /**
     * Returns the namespace of the given class name.
     *
     * @param string $name Class name.
     *
     * @return string Namespace.
     */
    protected function getFilenameFromClass($namespace, $class)
    {
        $namespace = str_replace('\\', '/', str_replace('App', '', $namespace));

        return app_path($namespace ? str_replace('\\', '/', $namespace) . '/' : '') . $class . '.php';
    }
}