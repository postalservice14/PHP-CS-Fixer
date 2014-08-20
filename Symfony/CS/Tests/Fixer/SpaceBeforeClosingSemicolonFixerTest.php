<?php
/*
 * This file is part of the Symfony CS utility.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Symfony\CS\Tests\Fixer;

use Symfony\CS\Fixer\SpaceBeforeClosingSemicolonFixer;

class SpaceBeforeClosingSemicolonFixerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideClosingTagExamples
     */
    public function testOneLineFix($expected, $input)
    {
        $fixer = new SpaceBeforeClosingSemicolonFixer();
        $file = new \SplFileInfo(__FILE__);

        $this->assertEquals($expected, $fixer->fix($file, $input));
    }

    public function provideClosingTagExamples()
    {
        return array(
            array(
                '<?php echo "$this->foo(\'with param containing ;\') ;"; ?>',
                '<?php echo "$this->foo(\'with param containing ;\') ;" ; ?>'
            ),
            array('<?php $this->foo(); ?>', '<?php $this->foo() ; ?>'),
            array(
                '<?php $this->foo(\'with param containing ;\'); ?>',
                '<?php $this->foo(\'with param containing ;\') ; ?>'
            ),
            array(
                '<?php $this->foo(\'with param containing ) ; \'); ?>',
                '<?php $this->foo(\'with param containing ) ; \') ; ?>'
            ),
            array(
                '<?php $this->foo("with param containing ) ; "); ?>',
                '<?php $this->foo("with param containing ) ; ") ; ?>'
            ),
            array('<?php $this->foo(); ?>', '<?php $this->foo(); ?>'),
            array(
                '<?php $this->foo("with semicolon in string) ; "); ?>',
                '<?php $this->foo("with semicolon in string) ; "); ?>'
            ),
            array('<?php

$this->foo();

?>
',
                '<?php

$this->foo() ;

?>
')
        );
    }
}
