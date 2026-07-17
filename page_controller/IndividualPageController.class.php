<?php
class IndividualPageController extends BaseTemplateController
{

    function displayIndividualPage($array = [])
    {
        return $this->renderArticleDetail($array['id']);
    }
}
?>
