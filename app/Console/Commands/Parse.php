<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpParser\Error;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeFinder;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;

class Parse extends Command
{
    protected $signature = 'parse';

    public function handle()
    {
        $code = file_get_contents('app/Http/Controllers/UserController.php');

        $parser = (new ParserFactory())->createForNewestSupportedVersion();
        try {
            $ast = $parser->parse($code);
        } catch (Error $error) {
            echo "Parse error: {$error->getMessage()}\n";
            return;
        }

        $nodeFinder = new NodeFinder();

        /** @var ClassMethod[] $methods */
        $methods = $nodeFinder->findInstanceOf($ast, ClassMethod::class);
        $methods = array_map(function (ClassMethod $method) {
            return [
                'name' => $method->name->name,
                'returnType' => $method->returnType ? $method->returnType->toString() : null,
                'visibility' => $method->flags & Node\Stmt\Class_::MODIFIER_PUBLIC ? 'public' : 'private',
            ];
        }, $methods);

        var_dump($methods);
    }
}
