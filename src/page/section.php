<?php

class Section
{
    /**
     * Section data.
     *
     * @var \Themosis\Core\DataContainer
     */
    protected $data;

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
		$section = new Section();

        $params = compact('slug', 'name');

        foreach ($params as $var => $param)
        {
            if (!is_string($param))
            {
                throw new \Exception('Invalid section parameter "'.$var.'"');
            }
        }

       $section->data['slug'] = $slug;
       $section->data['name'] = $name;
       $section->data['args'] = $data;

        if (!is_null($view))
        {
            $section->view = $view;
        }

        return $section;
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
        return$this->data;
    }

} 