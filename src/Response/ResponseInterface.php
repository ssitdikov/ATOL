<?php
/**
 * User: Salavat Sitdikov
 */

namespace SSitdikov\ATOL\Response;


interface ResponseInterface extends \JsonSerializable
{

    public function __construct(\stdClass $json);

}