<?php
/**
 * BSD 3-Clause License
 *
 * Copyright (c) 2019, TASoft Applications
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *  Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 *
 *  Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 *  Neither the name of the copyright holder nor the names of its
 *   contributors may be used to endorse or promote products derived from
 *   this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

namespace Skyline\API\Controller;

use Skyline\API\Render\PartialTemplateRender;
use Skyline\Render\Info\RenderInfoInterface;
use Skyline\Render\Model\ExtractableArrayModel;
use Skyline\Router\Description\ActionDescriptionInterface;
use Traversable;

/**
 * Class AbstractPartialTemplateAPIActionController adjusts the renderTemplate method, to pass a template and data to passthru the template
 * @package Skyline\API\Controller
 */
class AbstractPartialTemplateAPIActionController extends AbstractAPIActionController
{
    public function performAction(ActionDescriptionInterface $actionDescription, RenderInfoInterface $renderInfo)
    {
        if(!$this->isPreflightRequest($this->request)) {
            $renderInfo->set( RenderInfoInterface::INFO_PREFERRED_RENDER, PartialTemplateRender::RENDER_NAME);
        }
        return parent::performAction($actionDescription, $renderInfo);
    }

    /**
     * @param $template
     * @param iterable|array|Traversable|null $model
     */
    protected function renderTemplate($template, $model = NULL)
    {
        $this->getRenderInfo()->set( RenderInfoInterface::INFO_TEMPLATE, $template );
        if($model && !($model instanceof ExtractableArrayModel))
            $model = new ExtractableArrayModel( $model );

        if($model)
            $this->getRenderInfo()->set(RenderInfoInterface::INFO_MODEL, $model);
    }
}