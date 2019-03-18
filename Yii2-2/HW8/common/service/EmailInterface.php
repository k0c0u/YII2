<?php
namespace common\services;
/**
 * Interface EmailInterface
 * @package common\services
 */
interface EmailInterface
{
    /**
     * @param string $to
     * @param string $subject
     * @param string $viewHTML
     * @param string $viewText
     * @param array  $data
     *
     * @return mixed
     */
    public function send(string $to, string $subject, string $viewHTML, string $viewText, array $data);
}