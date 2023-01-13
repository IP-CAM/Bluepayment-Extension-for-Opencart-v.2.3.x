<?php

namespace BluePayment\Helper;

final class ParamSuffixer
{
    public function addSuffix($param)
    {
        return sprintf('%s-%s', $param, time());
    }

    public function removeSuffix($param)
    {
        $param_parts = explode('-', $param);

        return $param_parts[0];
    }
}
