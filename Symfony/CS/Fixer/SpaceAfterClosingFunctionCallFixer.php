<?php
/*
 * This file is part of the PHP CS utility.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Symfony\CS\Fixer;

use Symfony\CS\FixerInterface;
use Symfony\CS\Token;
use Symfony\CS\Tokens;

/**
 * @author John Kelly <johnmkelly86@gmail.com>
 */
class SpaceAfterClosingFunctionCallFixer implements FixerInterface
{
    /**
     * Fixes a file.
     *
     * @param \SplFileInfo $file    A \SplFileInfo instance
     * @param string       $content The file content
     *
     * @return string The fixed file content
     */
    public function fix(\SplFileInfo $file, $content)
    {
        $tokens = Tokens::fromCode($content);

        foreach ($tokens as $index => $token) {
            /** @var Token $token */
            if ($token->isArray()) {
                continue;
            }

            if (';' === $token->content) {
                $prevNonWhitespaceIndex = null;
                $prevNonWhitespaceToken = $tokens->getPrevNonWhitespace($index, array(), $prevNonWhitespaceIndex);

                if (!$prevNonWhitespaceToken->isArray()) {
                    for ($i = $index - 1; $i > $prevNonWhitespaceIndex; --$i) {
                        $tokens[$i]->clear();
                    }
                }

                continue;
            }
        }

        return $tokens->generateCode();
    }

    /**
     * Returns the level of CS standard.
     *
     * Can be one of self::PSR1_LEVEL, self::PSR2_LEVEL, or self::ALL_LEVEL
     */
    public function getLevel()
    {
        // defined in PSR-2 4.3
        return FixerInterface::PSR2_LEVEL;
    }

    /**
     * Returns the priority of the fixer.
     *
     * The default priority is 0 and higher priorities are executed first.
     */
    public function getPriority()
    {
        return 0;
    }

    /**
     * Returns true if the file is supported by this fixer.
     *
     * @param \SplFileInfo $file
     * @return bool true if the file is supported by this fixer, false otherwise
     */
    public function supports(\SplFileInfo $file)
    {
        return 'php' == pathinfo($file->getFilename(), PATHINFO_EXTENSION);
    }

    /**
     * Returns the name of the fixer.
     *
     * The name must be all lowercase and without any spaces.
     *
     * @return string The name of the fixer
     */
    public function getName()
    {
        return 'space_after_closing_function_call';
    }

    /**
     * Returns the description of the fixer.
     *
     * A short one-line description of what the fixer does.
     *
     * @return string The description of the fixer
     */
    public function getDescription()
    {
        return 'Space after closing parentheses of method call is prohibited.';
    }
}
