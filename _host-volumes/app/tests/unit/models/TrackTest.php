<?php

namespace tests\unit\models;

use app\models\Track;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class TrackTest extends \Codeception\Test\Unit
{
    public function testTrackCreation()
    {
        $track = new Track();
        $track->track_number = "unit test track number";
        $track->setStatusToNew();
        assertTrue($track->validate());
        verify($track->getErrors())->empty();
        assertTrue($track->isStatusNew());
        assertFalse($track->isStatusInprogress());
        assertFalse($track->isStatusCanceled());
        assertFalse($track->isStatusFailed());
        assertFalse($track->isStatusCompleted());
    }

    public function testTrackNumberRequiredWithMinAndMaxLength()
    {
        $track = new Track();
        $track->validate('track_number');
        assertEquals('Track Number cannot be blank.', $track->getFirstError('track_number'));
        $track->track_number = 'unique track number 987987897';
        assertTrue($track->validate('track_number'));
        $track->track_number = 'u';
        $track->validate('track_number');
        assertEquals('Track Number should contain at least 5 characters.', $track->getFirstError('track_number'));
        for ($i = 0; $i < 1000; $i++) {
            $track->track_number .= 'u';
        }
        $track->validate('track_number');
        assertEquals('Track Number should contain at most 255 characters.', $track->getFirstError('track_number'));
    }

    public function testTrackStatusRequiredAndInList()
    {
        $track = new Track();
        $track->validate('status');
        assertEquals('Status cannot be blank.', $track->getFirstError(attribute: 'status'));
        $track->status = 'illegal';
        $track->validate();
        assertEquals('Status is invalid.', $track->getFirstError(attribute: 'status'));
        $track->status = 'new';
        assertTrue($track->validate('status'));
        assertTrue($track->isStatusNew());
        $track->status = 'in_progress';
        assertTrue($track->isStatusInprogress());
        assertTrue($track->validate('status'));
        $track->status = 'completed';
        assertTrue($track->isStatusCompleted());
        assertTrue($track->validate('status'));
        $track->status = 'failed';
        assertTrue($track->isStatusFailed());
        assertTrue($track->validate('status'));
        $track->status = 'canceled';
        assertTrue($track->isStatusCanceled());
        assertTrue($track->validate('status'));
    }
}
