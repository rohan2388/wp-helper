<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use RD\WP\Helper;

function get_template_directory(){
	return dirname(__FILE__);
}

final class HelperTest extends TestCase {
	use \phpmock\phpunit\PHPMock;

	/**
	 * @test
	 * @testdox inline_styles - converts array to css string
	 */
    public function inline_styles(): void {
        $this->assertEquals(
            'color: red;',
            Helper::inline_styles([
				'color' => 'red'
			])
        );
	}
	/**
	 * @test
	 * @testdox classes - glues array of classes into string
	 */
	public function classes(): void {
		$this->assertEquals(
			'class3 class1 class2',
			Helper::classes([
				'class1', 'class2'	
			], 'class3' )
		);

		$this->assertEquals(
			' class1 class2',
			Helper::classes([
				'class1', 'class2'	
			])
		);
	}

	/**
	 * @test
	 * @testdox template - locate and load template file
	 */
	public function template(): void {
		$test = 'test variable';
		$this->assertEquals(
			"Template file goes here (${test})",
			Helper::template( 'test', [
				'test' => $test 
			])
		);
	}


	/**
	 * @test
	 * @testdox img2x - attachment image id to html img tag
	 */
	public function img2x(): void{
		$mock = $this->getFunctionMock( 'RD\\WP\\', "wp_get_attachment_image_src");
        $mock->expects($this->any())->willReturnCallback(function( $url, $size ){
			return [ sprintf('%s?size=%s', $url, $size) , 800, 600];
		});

		$this->assertEquals(
			'<img src="http://yourdomain.com/image.png?size=full" srcset="http://yourdomain.com/image.png?size=full 2x" width="400" height="300">',
			Helper::img2x( 'http://yourdomain.com/image.png', 'full' )
		);
		$this->assertEquals(
			'<img src="http://yourdomain.com/image.png?size=small" srcset="http://yourdomain.com/image.png?size=small 2x" width="400" height="300">',
			Helper::img2x( 'http://yourdomain.com/image.png', 'small' )
		);
	}

	/**
	 * @test
	 * @testdox echo2string - returns function echo output as string
	 */
	public function echo2string(){
		$text = 'Test text';
		$this->assertEquals(
			$text,
			Helper::echo2string( 'printf', $text )
		);
	}

	/**
	 * @test
	 * @testdox array_insert - insert an element into certain position in array
	 */
	public function array_insert(){
		$arr = ['Before', 'After'];
		$this->assertEquals(
			['Before', 'OK', 'After'],
			Helper::array_insert( $arr, 1, 'OK' )
		);
	}
}


