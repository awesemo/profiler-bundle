<?php

namespace Movent\ProfilerBundle\Services;

interface CloudInterface
{
    function getProfile();
    function save();
}
