<?php

@ ini_set( 'date.timezone', 'Etc/GMT＋0' );
@ date_default_timezone_set( 'Etc/GMT＋0' );

@ ini_set( 'display_errors',	'on' );
@ ini_set( 'max_execution_time',	'60' );
@ ini_set( 'max_input_time',	'0' );
@ ini_set( 'memory_limit',	'4096M' );

//	mb 环境定义
mb_internal_encoding( "UTF-8" );

//	Turn on output buffering
ob_start();


require_once( __DIR__ . "/../vendor/autoload.php");
require_once( __DIR__ . "/../src/CDId.php");



use dekuan\dedid\CDId;



/**
 * Created by PhpStorm.
 * User: xing
 * Date: 03/08/2017
 * Time: 9:07 PM
 */
class TestIdGenerator extends PHPUnit_Framework_TestCase
{
	public function testCreateNew()
	{
		$cDId		= CDId::getInstance();

		$arrResult	= [];
		$arrUnique	= [];
		$nHostMax	= 63;
		$nTableMax	= 63;

		for ( $i = 0; $i < 1; $i ++ )
		{
			for ( $nCenter = 0; $nCenter <= $nHostMax; $nCenter ++ )
			{
				for ( $nNode = 0; $nNode <= $nTableMax; $nNode ++ )
				{
					$arrD	= [];
					$nNewId	= $cDId->createId( $nCenter, $nNode, $arrD );
					$arrId	= $cDId->parseId( $nNewId );
					
					$sHexId	= dechex( $nNewId );

					//	...
					$this->assertSame( $arrId, $arrD );

					$arrItem =
						[
							'h'	=> $nCenter,
							't'	=> $nNode,
							'id'	=> $nNewId,
							'r'	=> $arrId,
						];
					//$sKey	= sprintf( "%d", $nNewId );

					$arrResult[] 		= $arrItem;
					$arrUnique[ $nNewId ]	= $arrItem;
				}
			}			
		}


		var_dump( count( $arrResult ), count( $arrUnique ) );

		file_put_contents( 'test-result.json', json_encode( $arrResult ) );
		file_put_contents( 'test-unique.json', json_encode( $arrUnique ) );

	}


	////////////////////////////////////////////////////////////////////////////////
	//	Private
	//


	

}
