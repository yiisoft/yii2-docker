<?php

declare(strict_types=1);

namespace tests\unit\controllers;

use app\models\Track;

use yii\web\HeaderCollection;
use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use app\modules\api\v1\controllers\TrackController;
use yii\web\Request;
use yii;
use yii\web\NotFoundHttpException;

class TrackApiTest extends \Codeception\Test\Unit
{
    protected function setUp(): void
    {
        parent::setUp();
        Yii::$app->db->createCommand()->truncateTable(Track::tableName())->execute();
    }

    private function createTrackWithStatus(string $status): mixed
    {
        $requestMock = $this->mockRequestComponent('POST');
        $requestMock->method('getBodyParams')->willReturn([
            'status' => $status,
            'track_number' => 'unique number' . mt_rand(1, 10000000),
        ]);
        Yii::$app->set('request', $requestMock);
        Yii::$app->controller = new TrackController('track', Yii::$app);
        $result = Yii::$app->controller->run('create');
        return $result;
    }

    public function testCreateNew(): void
    {
        assertArrayHasKey('id', $this->createTrackWithStatus(Track::STATUS_NEW));
        assertSame(2, $this->createTrackWithStatus(Track::STATUS_CANCELED)['id']);
        assertSame(3, $this->createTrackWithStatus(Track::STATUS_COMPLETED)['id']);
        assertSame(4, $this->createTrackWithStatus(Track::STATUS_FAILED)['id']);
        assertSame(5, $this->createTrackWithStatus(Track::STATUS_IN_PROGRESS)['id']);
    }

    private function mockRequestComponent($method): Request
    {
        $requestMock = $this->createMock(Request::class);
        $requestMock->method('getMethod')->willReturn($method);
        $headersCollection = new HeaderCollection();
        $headersCollection->add('Authorization', 'Bearer 101-token');
        $headersCollection->add('Content-Type', 'application/json');
        $requestMock->method('getHeaders')->willReturn($headersCollection);
        return $requestMock;
    }

    public function testUpdate(): void
    {
        $targetStatus = Track::STATUS_IN_PROGRESS;
        $this->createTrackWithStatus(Track::STATUS_NEW);
        $requestMock = $this->mockRequestComponent('PATCH');
        $requestMock->method('getBodyParams')->willReturn([
            'status' => $targetStatus,
        ]);
        Yii::$app->set('request', $requestMock);
        Yii::$app->controller = new TrackController('track', Yii::$app);
        $result = Yii::$app->controller->run('update', ['id' => 1, 'status' => $targetStatus]);
        codecept_debug(['Update result' => $result]);
        assertSame(Track::STATUS_IN_PROGRESS, $result['status'], 'Initial status not changed!');
    }
    public function testDelete(): void
    {
        $this->createTrackWithStatus(Track::STATUS_NEW);
        $requestMock = $this->mockRequestComponent('DELETE');
        Yii::$app->set('request', $requestMock);
        Yii::$app->controller = new TrackController('track', Yii::$app);
        $result = Yii::$app->controller->run('delete', ['id' => 1]);
        assertNull($result);
        $this->expectException(NotFoundHttpException::class);
        Yii::$app->controller->run('delete', ['id' => 1]);
    }

    public function testView(): void
    {
        $createdTrack = $this->createTrackWithStatus(Track::STATUS_NEW);
        $requestMock = $this->mockRequestComponent('HEAD');
        Yii::$app->set('request', $requestMock);
        Yii::$app->controller = new TrackController('track', Yii::$app);
        $result = Yii::$app->controller->run('view', ['id' => $createdTrack['id']]);
        codecept_debug(['view result' => $result]);
        assertSame($createdTrack['track_number'], $result['track_number'], 'Viwed not same track!');
    }

    public function testList(): void
    {
        $createdTracks = [];
        foreach (Track::optsStatus() as $value) {
            $createdTracks[] = $this->createTrackWithStatus($value);
        }
        codecept_debug($createdTracks);
        $requestMock = $this->mockRequestComponent('GET');
        Yii::$app->set('request', $requestMock);
        Yii::$app->controller = new TrackController('track', Yii::$app);
        $result = Yii::$app->controller->run('index');
        codecept_debug(['list result' => $result]);
        foreach ($createdTracks as $key => $createdTrack) {
            assertArrayHasKey($key, $result);
            foreach ($createdTrack as $field => $value) {
                assertSame($result[$key][$field], $value);
            }
        }
    }

    public function testFilter(): void
    {
        $this->createTrackWithStatus(Track::STATUS_NEW);
        $this->createTrackWithStatus(Track::STATUS_IN_PROGRESS);
        $this->createTrackWithStatus(Track::STATUS_IN_PROGRESS);
        $requestMock = $this->mockRequestComponent('GET');
        $requestMock->method('getQueryParams')->willReturn(['filter' => ['status' => Track::STATUS_IN_PROGRESS]]);
        Yii::$app->set('request', $requestMock);
        Yii::$app->controller = new TrackController('track', Yii::$app);
        $result = Yii::$app->controller->run('index');
        assertCount(2, $result);
        codecept_debug(['filter track by status' => $result]);
    }
    public function testBulkUpdate(): void
    {
        $this->createTrackWithStatus(Track::STATUS_NEW);
        $this->createTrackWithStatus(Track::STATUS_IN_PROGRESS);

        $bodyParams = [
            [
                'status' => Track::STATUS_IN_PROGRESS,
                'id' => 1
            ],
            [
                'status' => Track::STATUS_COMPLETED,
                'id' => 2
            ],
        ];
        $requestMock = $this->mockRequestComponent('PUT');
        $requestMock->method('getBodyParams')->willReturnCallback(
            callback: function () use (&$bodyParams) {
                return $bodyParams;
            }
        );
        $requestMock->method('setBodyParams')->willReturnCallback(
            function ($arg) use ($requestMock, &$bodyParams) {
                codecept_debug(['setBodyParams called with argument' => $arg]);
                $bodyParams = $arg;
            }
        );
        Yii::$app->set('request', $requestMock);
        Yii::$app->controller = new TrackController('track', Yii::$app);
        $result = Yii::$app->controller->run('bulkupdate');
        codecept_debug(['bulk update result' => $result]);
        foreach ($result as $key => $updatedTrack) {
            assertSame($bodyParams[$key]['status'], $updatedTrack['status'], 'Status not updated during bulk update!');
        }
    }
}
