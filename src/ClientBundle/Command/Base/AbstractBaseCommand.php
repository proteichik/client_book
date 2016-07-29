<?php

namespace ClientBundle\Command\Base;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

abstract class AbstractBaseCommand extends ContainerAwareCommand
{
    protected function getInfoMsg($message)
    {
        $this->getLogger()->info($message);
        return '<info>[INFO]: ' . $message . '</info>';
    }

    protected function getQuestionMsg($message)
    {
        return '<question>[QUESTION]: ' . $message . '</question>';
    }

    protected function getCommentMsg($message)
    {
        return '<comment>[COMMENT]: ' . $message . '</comment>';
    }

    protected function getErrorMsg($message)
    {
        $this->getLogger()->error($message);
        return '<error>[ERROR]: ' . $message . '</error>';
    }

    protected function getLogger()
    {
        return $this->getContainer()->get('client.logger.console_logger');
    }
}