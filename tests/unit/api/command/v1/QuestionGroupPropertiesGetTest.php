<?php

namespace ls\tests\unit\api\command\v1;

use Eloquent\Phony\Phpunit\Phony;
use Permission;
use QuestionGroup;
use ls\tests\TestBaseClass;
use ls\tests\unit\api\command\mixin\AssertResponse;
use LimeSurvey\Api\Command\V1\QuestionGroupPropertiesGet;
use LimeSurvey\Api\Command\Request\Request;
use LimeSurvey\Api\Command\Response\Status\StatusSuccess;
use LimeSurvey\Api\Command\Response\Status\StatusErrorBadRequest;
use LimeSurvey\Api\Command\Response\Status\StatusErrorNotFound;
use LimeSurvey\Api\Command\Response\Status\StatusErrorUnauthorised;
use LimeSurvey\Api\ApiSession;

/**
 * @testdox API command v1 QuestionGroupPropertiesGet.
 *
 */
class QuestionGroupPropertiesGetTest extends TestBaseClass
{
    use AssertResponse;

    /**
     * @testdox Returns invalid session response (error unauthorised) if session key is not valid.
     */
    public function testQuestionGroupPropertiesGetInvalidSession()
    {
        $request = new Request(array(
            'sessionKey' => 'not-a-valid-session-id',
            'groupID' => 'groupID',
            'groupSettings' => 'groupSettings',
            'language' => 'language'
        ));
        $response = (new QuestionGroupPropertiesGet())->run($request);

        $this->assertResponseInvalidSession($response);

        $this->assertResponseDataStatus(
            $response,
            'Invalid session key'
        );
    }

    /**
     * @testdox Returns error not-found if group id is not valid.
     */
    public function testQuestionGroupPropertiesGetInvalidGroupId()
    {
        $request = new Request(array(
            'sessionKey' => 'mock',
            'groupID' => 'no-found',
            'groupSettings' => 'groupSettings',
            'language' => 'language'
        ));

        $mockApiSessionHandle = Phony::mock(ApiSession::class);
        $mockApiSessionHandle
            ->checkKey
            ->returns(true);
        $mockApiSession = $mockApiSessionHandle->get();

        $command = new QuestionGroupPropertiesGet();
        $command->setApiSession($mockApiSession);

        $response = $command->run($request);

        $this->assertResponseStatus(
            $response,
            new StatusErrorNotFound()
        );

        $this->assertResponseDataStatus(
            $response,
            'Error: Invalid group ID'
        );
    }

    /**
     * @testdox Returns invalid session response (error unauthorised) user does not have permission.
     */
    public function testQuestionGroupPropertiesGetNoPermission()
    {
        $request = new Request(array(
            'sessionKey' => 'mock',
            'groupID' => 'mock',
            'groupSettings' => 'groupSettings',
            'language' => 'language'
        ));

        $mockApiSessionHandle = Phony::mock(ApiSession::class);
        $mockApiSessionHandle
            ->checkKey
            ->returns(true);
        $mockApiSession = $mockApiSessionHandle->get();

        $mockQuestionGroupModelHandle = Phony::mock(QuestionGroup::class);
        $mockQuestionGroupModel = $mockQuestionGroupModelHandle->get();

        $mockModelPermissionHandle = Phony::mock(Permission::class);
        $mockModelPermissionHandle->hasSurveyPermission
            ->returns(false);
        $mockModelPermission = $mockModelPermissionHandle->get();

        $command = new QuestionGroupPropertiesGet();
        $command->setApiSession($mockApiSession);
        $command->setQuestionGroupModelWithL10nsById($mockQuestionGroupModel);
        $command->setPermissionModel($mockModelPermission);

        $response = $command->run($request);

        $this->assertResponseStatus(
            $response,
            new StatusErrorUnauthorised()
        );

        $this->assertResponseDataStatus(
            $response,
            'No permission'
        );
    }

    /**
     * @testdox Returns error bad request if language is not valid.
     */
    public function testQuestionGroupPropertiesGetInvalidLanguage()
    {
        $request = new Request(array(
            'sessionKey' => 'mock',
            'groupID' => 'mock',
            'groupSettings' => 'groupSettings',
            'language' => 'invalid-language'
        ));

        $mockApiSessionHandle = Phony::mock(ApiSession::class);
        $mockApiSessionHandle
            ->checkKey
            ->returns(true);
        $mockApiSession = $mockApiSessionHandle->get();

        $mockQuestionGroupModelHandle = Phony::mock(QuestionGroup::class);
        $mockQuestionGroupModel = $mockQuestionGroupModelHandle->get();

        $mockModelPermissionHandle = Phony::mock(Permission::class);
        $mockModelPermissionHandle->hasSurveyPermission
            ->returns(true);
        $mockModelPermission = $mockModelPermissionHandle->get();

        $command = new QuestionGroupPropertiesGet();
        $command->setApiSession($mockApiSession);
        $command->setQuestionGroupModelWithL10nsById($mockQuestionGroupModel);
        $command->setPermissionModel($mockModelPermission);

        $response = $command->run($request);

        $this->assertResponseStatus(
            $response,
            new StatusErrorBadRequest()
        );

        $this->assertResponseDataStatus(
            $response,
            'Error: Invalid language'
        );
    }

    /**
     * @testdox Returns error bad-request if no valid settings specified.
     */
    public function testQuestionGroupPropertiesGetNoValidSettingsSpecified()
    {
        $request = new Request(array(
            'sessionKey' => 'mock',
            'groupID' => 'mock',
            'groupSettings' => array('invalid-setting'),
            'language' => 'en'
        ));

        $mockApiSessionHandle = Phony::mock(ApiSession::class);
        $mockApiSessionHandle
            ->checkKey
            ->returns(true);
        $mockApiSession = $mockApiSessionHandle->get();

        $mockQuestionGroupModelHandle = Phony::mock(QuestionGroup::class);
        $mockQuestionGroupModel = $mockQuestionGroupModelHandle->get();

        $mockModelPermissionHandle = Phony::mock(Permission::class);
        $mockModelPermissionHandle->hasSurveyPermission
            ->returns(true);
        $mockModelPermission = $mockModelPermissionHandle->get();

        $command = new QuestionGroupPropertiesGet();
        $command->setApiSession($mockApiSession);
        $command->setQuestionGroupModelWithL10nsById($mockQuestionGroupModel);
        $command->setPermissionModel($mockModelPermission);

        $response = $command->run($request);

        $this->assertResponseStatus(
            $response,
            new StatusErrorBadRequest()
        );

        $this->assertResponseDataStatus(
            $response,
            'No valid Data'
        );
    }

    /**
     * @testdox Returns success with default settings if no settings specified.
     */
    public function testQuestionGroupPropertiesGetDefaultSettings()
    {
        $request = new Request(array(
            'sessionKey' => 'mock',
            'groupID' => 'mock',
            'groupSettings' => array(),
            'language' => 'en'
        ));

        $mockApiSessionHandle = Phony::mock(ApiSession::class);
        $mockApiSessionHandle
            ->checkKey
            ->returns(true);
        $mockApiSession = $mockApiSessionHandle->get();

        $mockQuestionGroupModelHandle = Phony::mock(QuestionGroup::class);
        $mockQuestionGroupModel = $mockQuestionGroupModelHandle->get();

        $mockModelPermissionHandle = Phony::mock(Permission::class);
        $mockModelPermissionHandle->hasSurveyPermission
            ->returns(true);
        $mockModelPermission = $mockModelPermissionHandle->get();

        $command = new QuestionGroupPropertiesGet();
        $command->setApiSession($mockApiSession);
        $command->setQuestionGroupModelWithL10nsById($mockQuestionGroupModel);
        $command->setPermissionModel($mockModelPermission);

        $response = $command->run($request);

        $this->assertResponseStatus(
            $response,
            new StatusSuccess()
        );
    }
}