<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/12/20
 * Time: 14:39
 */

namespace Universe\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Universe\App;

class CreateIdeCommand extends Command
{
    protected function configure()
    {
        $this->setName('create:ide')->setDescription('创建facades的ide提示');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $arrFacades = App::get('facade')->getFacades();

        if ($arrFacades && is_array($arrFacades)) {
            foreach ($arrFacades as $facade => $containers) {
                $realObj = $containers::getFacadeAccessor();
                if (!is_object($realObj)) {
                    $realObj = new $realObj();
                }
                $this->createObjIde($facade, $realObj);
            }
        }
        $output->writeln('<info>创建成功 </info>');
    }

    protected function createObjIde($facade, $object)
    {
        $nn              = PHP_EOL;
        $ReflectionClass = new \ReflectionClass($object);
        foreach ($ReflectionClass->getMethods() as $reflectionMethod) {
            if ($reflectionMethod->getName() != '__construct') {
                if ($reflectionMethod->isPublic()) {
                    $publicFunctions[] = $this->getFunIde($reflectionMethod);
                }
            }
        }
        $strFunction = implode(PHP_EOL, $publicFunctions);
        $strFunction = "<?php{$nn}{$nn}class {$facade}{$nn}{{$nn}{$strFunction}{$nn} }";
        $savePath    = App::getPath() . '/bootstrap/cache/ide';
        if (!is_dir($savePath)) {
            mkdir($savePath, 0755, true);
        }
        file_put_contents($savePath . '/' . $facade . '.php', $strFunction);
    }

    protected function getFunIde(\ReflectionMethod $reflectionMethod)
    {
        $nn         = PHP_EOL;
        $s4         = '    ';
        $Parameters = $reflectionMethod->getParameters();
        $arrParam   = [];
        foreach ($Parameters as $parameter) {
            $objType = $parameter->getType();
            if (is_object($objType)) {
                if (method_exists($objType, 'getName')) {
                    $type = $objType->getName() . ' ';
                } else {
                    $type = $objType->__toString() . ' ';
                }
                $lineKey = __FILE__.__LINE__;

                try {
                    $DefaultValue = $parameter->getDefaultValue();
                } catch (\Exception $exception) {
                    $DefaultValue = $lineKey;
                }

                if ($DefaultValue !== $lineKey) {
                    $DefaultValue = '=' . str_replace([PHP_EOL, ' '], '', var_export($DefaultValue, true));
                }else{
                    $DefaultValue = '';
                }
                $arrParam[] = $type . '$' . $parameter->getName() . $DefaultValue;
            } elseif( $parameter->isOptional() ) {
                if( $parameter->allowsNull() ){
                    try{
                        $DefaultValue = $parameter->getDefaultValue();
                    }catch (\Exception $exception){
                        $DefaultValue = '可变参数';
                    }
                    $DefaultValue = '=' . str_replace([PHP_EOL, ' '], '', var_export($DefaultValue, true));
                    $arrParam[] = '$' . $parameter->getName(). $DefaultValue;
                }else{
                    $arrParam[] = '$' . $parameter->getName()."=''";
                }
            }  else {
                $arrParam[] = '$' . $parameter->getName();
            }
        }
        $strReturn       = "// 这是给编辑器使用的，不执行";
        $stringParam     = implode(',', $arrParam);
        $publicFunctions = "{$s4}{$reflectionMethod->getDocComment()}{$nn}{$s4}public static function {$reflectionMethod->getName()}({$stringParam}){$nn}{$s4}{{$nn}{$s4}{$s4}{$strReturn}{$nn}{$s4}}{$nn}";
        return $publicFunctions;
    }
}