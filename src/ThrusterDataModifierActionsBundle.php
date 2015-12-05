<?php

namespace Thruster\Bundle\DataModifierActionsBundle;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class ThrusterDataModifierActionsBundle
 *
 * @package Thruster\Bundle\DataModifierActionsBundle
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class ThrusterDataModifierActionsBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(
            new class implements CompilerPassInterface
            {
                /**
                 * @inheritDoc
                 */
                public function process(ContainerBuilder $container)
                {
                    $executorId         = 'thruster_data_modifier_actions.executor';
                    $executorDefinition = new Definition(
                        'Thruster\Action\DataModifierActions\DataModifyActionExecutor',
                        [new Reference('thruster_data_modifiers')]
                    );

                    $executorDefinition->addTag('thruster_action_executor', []);

                    $container->setDefinition($executorId, $executorDefinition);
                }
            }
        );
    }
}
