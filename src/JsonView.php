<?php

/**
 * Part of the Joomla Framework View Package
 *
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\View;

/**
 * Joomla Framework JSON View Class
 *
 * @since  2.0.0
 */
class JsonView extends AbstractView
{
    /**
     * The flags passed to json_encode() when rendering the view
     *
     * @var    integer
     * @since  __DEPLOY_VERSION__
     */
    private int $flags;

    /**
     * Method to instantiate the view.
     *
     * @param   integer  $flags  The flags to pass to json_encode(), a bitmask of the JSON_* constants.
     *
     * @since   __DEPLOY_VERSION__
     */
    public function __construct(int $flags = 0)
    {
        $this->flags = $flags;
    }

    /**
     * Retrieves the flags passed to json_encode() when rendering the view
     *
     * @return  integer
     *
     * @since   __DEPLOY_VERSION__
     */
    public function getFlags(): int
    {
        return $this->flags;
    }

    /**
     * Method to render the view.
     *
     * @return  string  The rendered view.
     *
     * @since   2.0.0
     * @throws  \RuntimeException if the data cannot be encoded as JSON
     */
    public function render()
    {
        try {
            return json_encode($this->getData(), $this->flags | JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new \RuntimeException(sprintf('Unable to encode the view data as JSON: %s', $e->getMessage()), $e->getCode(), $e);
        }
    }

    /**
     * Sets the flags passed to json_encode() when rendering the view
     *
     * @param   integer  $flags  A bitmask of the JSON_* constants, e.g. JSON_HEX_TAG | JSON_HEX_AMP.
     *
     * @return  $this
     *
     * @since   __DEPLOY_VERSION__
     */
    public function setFlags(int $flags): static
    {
        $this->flags = $flags;

        return $this;
    }
}
