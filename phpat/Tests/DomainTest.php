<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\PhpAT\Tests;

use PHPat\Selector\Selector;
use PHPat\Test\Attributes\TestRule;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

final class DomainTest extends ArchitectureTest
{
    #[TestRule]
    public function domainDoesNotDependOnOtherLayers(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace(self::NAMESPACE_DOMAIN))
            ->canOnly()
            ->dependOn()
            ->classes(
                Selector::isStandardClass(),
                Selector::inNamespace(self::NAMESPACE_DOMAIN),
            )
            ->because('This will break the Onion architecture');
    }
}
