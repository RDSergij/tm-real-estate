<?php

class Section
{
    /**
     * Section data.
     *
     * @var \Themosis\Core\DataContainer
     */
    protected static $data;

    /**
     * Section view.
     *
     * @var IRenderable
     */
    protected $view;

    /**
     * Section custom datas.
     *
     * @var array
     */
    protected $shared = [];

    /**
     * Define a Section instance. Used in Page sections.
     *
     * @param string $slug
     * @param string $name
     * @param array $data Custom properties for the section.
     * @param IRenderable $view
     * @throws \Exception
     * @return \Themosis\Page\Sections\SectionBuilder
     */
    public static function make($slug, $name, array $data = [], IRenderable $view = null)
    {
        $params = compact('slug', 'name');

        foreach ($params as $var => $param)
        {
            if (!is_string($param))
            {
                throw new \Exception('Invalid section parameter "'.$var.'"');
            }
        }

        self::$data['slug'] = $slug;
        self::$data['name'] = $name;
        self::$data['args'] = $data;

        if (!is_null($view))
        {
            $this->view = $view;
        }

        return $this;
    }

    /**
     * Register custom data for the section view.
     *
     * @param string|array $key
     * @param mixed $value
     * @return \Themosis\Page\Sections\SectionBuilder
     */
    public function with($key, $value = null)
    {
        if (is_array($key))
        {
            $this->shared = array_merge($this->shared, $key);
        }
        else
        {
            $this->shared[$key] = $value;
        }

        return $this;
    }

    /**
     * Return the section datas.
     *
     * @return DataContainer
     */
    public function getData()
    {
        return self::$data;
    }

} 