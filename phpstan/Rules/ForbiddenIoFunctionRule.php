<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\PhpStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<FuncCall>
 */
final class ForbiddenIoFunctionRule implements Rule
{
    /** @var list<string> */
    private const array FORBIDDEN_FUNCTIONS = [
        'copy',
        'file_get_contents',
        'file_put_contents',
    ];

    /** @var list<string> Namespace segments in which IO functions are forbidden */
    private const array RESTRICTED_NAMESPACES = [
        'thofman\KnowledgeBase\Domain',
        'thofman\KnowledgeBase\Application',
    ];

    public function getNodeType(): string
    {
        return FuncCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node->name instanceof Node\Name) {
            return [];
        }

        $functionName = strtolower(ltrim($node->name->toString(), '\\'));
        if (!in_array($functionName, self::FORBIDDEN_FUNCTIONS, true)) {
            return [];
        }

        $restrictedNamespace = $this->restrictedNamespace($scope->getNamespace());
        if ($restrictedNamespace === null) {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                sprintf(
                    'IO function "%s()" is forbidden in the "%s" namespace. Use dependency inversion instead.',
                    $functionName,
                    $restrictedNamespace,
                )
            )
                ->identifier('thofman.KnowledgeBase.forbiddenIoFunction')
                ->build(),
        ];
    }

    private function restrictedNamespace(?string $namespace): ?string
    {
        if ($namespace === null) {
            return null;
        }

        return array_find(
            self::RESTRICTED_NAMESPACES,
            static fn(string $restrictedNamespace): bool => str_contains($namespace, $restrictedNamespace),
        );
    }
}
