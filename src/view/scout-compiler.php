<?php
/**
 * Core Scout_Compiler class file
 *
 * @package photolab
 */

/**
 * Scout_Compiler class
 */
class Scout_Compiler extends Compiler implements ICompiler {

	/**
	 * The original view path.
	 *
	 * @var string
	 */
	protected $path;

	/**
	 * Opening and closing echo tags.
	 *
	 * @var array
	 */
	protected $echo_tags = array( '{{', '}}' );

	/**
	 * Opening and closing escaped tags.
	 *
	 * @var array
	 */
	protected $escaped_tags = array( '{{{', '}}}' );

	/**
	 * List of lines to add to templates.
	 *
	 * @var array
	 */
	protected $footer = array();

	/**
	 * Wordpress filesystem class
	 *
	 * @var null
	 */
	protected $wp_filesystem = null;

	/**
	 * Compiled content
	 *
	 * @var string
	 */
	protected $compiled_content = '';

	/**
	 * Construct Scout_Compiler class
	 *
	 * @param [type] $storage storage.
	 */
	public function __construct( $storage = null ) {
		$this->storage = $storage;
		$this->wp_filesystem = Utils::get_wp_filesystem();
		$this->create_storage_folder();
	}

	/**
	 * Auto create storage folder
	 */
	public function create_storage_folder() {
		if ( false == file_exists( $this->storage ) ) {
			wp_mkdir_p( $this->storage );
		}
	}

	/**
	 * Get compiled PHP content
	 *
	 * @return string PHP content.
	 */
	public function get_compiled_content() {
		return $this->compiled_content;
	}

	/**
	 * Compile the view at the given path.
	 *
	 * @param type $path compile path.
	 * @return void
	 */
	public function compile( $path ) {
		// Reset footer.
		$this->footer  = array();

		if ( $path ) {
			$this->setPath( $path );
		}

		// Compile the view content.
		$content = $this->compileString( $this->getViewContent( $path ) );
		if ( ! is_null( $this->storage ) ) {
			// Store the compiled view.
			$this->wp_filesystem->put_contents( $this->get_compiled_path( $this->getPath() ), $content );
		}
		$this->compiled_content = $content;
	}

	/**
	 * Compile the scout view file.
	 *
	 * @param type $content uncompiled content.
	 * @return string
	 */
	public function compileString( $content ) {
		$result = '';

		foreach ( token_get_all( $content ) as $token ) {
			$result .= is_array( $token ) ? $this->parseToken( $token ) : $token;
		}

		// Add extends lines at the end of compiled results
		// so we can inherit templates.
		if ( count( $this->footer ) > 0 ) {
			$result = ltrim( $result, PHP_EOL ).PHP_EOL.implode( PHP_EOL, array_reverse( $this->footer ) );
		}

		return $result;
	}

	/**
	 * Set the original view path.
	 *
	 * @param type $path set param path.
	 */
	public function setPath( $path ) {
		$this->path = $path;
	}

	/**
	 * Return the original view path.
	 *
	 * @return string
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * Parse token from template.
	 *
	 * @param array $token parse roken.
	 * @return string
	 */
	protected function parseToken( array $token ) {
		list( $id, $content ) = $token;

		if ( T_INLINE_HTML == $id ) {
			// Keep 'Echos' as last compiler.
			foreach ( array( 'Statements', 'Comments', 'Echos' ) as $type ) {
				$content = $this->{"compile{$type}"}( $content );
			}
		}

		return $content;
	}

	/**
	 * Compile to native PHP statements. Compile all methods
	 * that start with '@'.
	 *
	 * @param type $content content.
	 * @return string
	 */
	protected function compileStatements( $content ) {
		return preg_replace_callback(
			'/\B@(\w+)([ \t]*)(\( ( (?>[^()]+) | (?3) )* \))?/x',
			array( $this, 'compile_statements_cllback' ),
			$content
		);
	}

	/**
	 * It's need for PHP 5.2
	 *
	 * @param  [type] $match array.
	 * @return string
	 */
	public function compile_statements_cllback( $match ) {
		$compiler = $this;
		if ( method_exists( $compiler, $method = 'compile'.ucfirst( $match[1] ) ) ) {
			$match[0] = $compiler->$method( Utils::array_get( $match, 3 ) );
		}

		return isset( $match[3] ) ? $match[0] : $match[0].$match[2];
	}

	/**
	 * Compile to native PHP comments.
	 *
	 * @param type $content html content.
	 * @return string
	 */
	protected function compileComments( $content ) {
		$pattern = sprintf( '/%s--((.|\s)*?)--%s/', $this->echo_tags[0], $this->echo_tags[1] );

		return preg_replace( $pattern, '<?php /*$1*/ ?>', $content );
	}

	/**
	 * Compile to native PHP echos.
	 *
	 * @param type $content html content.
	 * @return string
	 */
	protected function compileEchos( $content ) {
		$difference = strlen( $this->echo_tags[0] ) - strlen( $this->escaped_tags[0] );

		if ( $difference > 0 ) {
			return $this->compileEscapedEchos( $this->compileRegularEchos( $content ) );
		}

		return $this->compileRegularEchos( $this->compileEscapedEchos( $content ) );
	}

	/**
	 * Compile regular echos.
	 *
	 * @param type $content html content.
	 * @return string
	 */
	protected function compileRegularEchos( $content ) {
		$pattern = sprintf( '/(@)?%s\s*(.+?)\s*%s(\r?\n)?/s', $this->echo_tags[0], $this->echo_tags[1] );
		return preg_replace_callback( $pattern, array( $this, 'compile_regular_echos_callback' ), $content );
	}

	/**
	 * It's need for PHP 5.2
	 *
	 * @param  [type] $matches array.
	 * @return string
	 */
	public function compile_regular_echos_callback( $matches ) {
		$compiler = $this;
		return $matches[1] ? substr( $matches[0], 1 ) : '<?php echo('.$compiler->compileEchoDefaults( $matches[2] ).'); ?>';
	}

	/**
	 * Compile escape echos.
	 *
	 * @param type $content html content.
	 * @return string
	 */
	protected function compileEscapedEchos( $content ) {
		$pattern = sprintf( '/%s\s*(.+?)\s*%s(\r?\n)?/s', $this->escaped_tags[0], $this->escaped_tags[1] );
		return preg_replace_callback( $pattern, array( $this, 'compile_escaped_echos_callback' ), $content );
	}

	/**
	 * It's need for PHP 5.2
	 *
	 * @param  [type] $matches array.
	 * @return string
	 */
	public function compile_escaped_echos_callback( $matches ) {
		$compiler = $this;
		return '<?php echo e('.$compiler->compileEchoDefaults( $matches[1] ).'); ?>';
	}

	/**
	 * Compile default echo content.
	 * Allow user to check for value existence by using the 'or' shortcut
	 * to define a default value.
	 *
	 * @param type $content html content.
	 * @return string
	 */
	protected function compileEchoDefaults( $content ) {
		return preg_replace( '/^(?=\$)(.+?)(?:\s+or\s+)(.+?)$/s', 'isset($1) ? $1 : $2', $content );
	}

	/**
	 * Compile the yield statements into valid PHP.
	 *
	 * @param type $expression yield expression.
	 * @return string
	 */
	protected function compileYield( $expression ) {
		return "<?php echo \$__env->yieldContent{$expression}; ?>";
	}

	/**
	 * Compile the section statements into valid PHP.
	 *
	 * @param type $expression section.
	 * @return string
	 */
	protected function compileSection( $expression ) {
		return "<?php \$__env->startSection{$expression}; ?>";
	}

	/**
	 * Compile the stop statements to valid PHP.
	 *
	 * @param type $expression stop section.
	 * @return string
	 */
	protected function compileStop( $expression ) {
		return '<?php \$__env->stopSection(); ?>';
	}

	/**
	 * Compile the show statements into valid PHP.
	 *
	 * @param type $expression section.
	 * @return string
	 */
	protected function compileShow( $expression ) {
		return '<?php echo \$__env->yieldSection(); ?>';
	}

	/**
	 * Compile the overwrite statements into valid PHP.
	 *
	 * @param type $expression section.
	 * @return string
	 */
	protected function compileOverwrite( $expression ) {
		return '<?php \$__env->stopSection(true); ?>';
	}

	/**
	 * Compile include statements.
	 *
	 * @param type $expression include.
	 * @return string
	 */
	protected function compileInclude( $expression ) {
		if ( Utils::starts_with( $expression, '(' ) ) {
			$expression = substr( $expression, 1, -1 );
		}

		return "<?php echo View::make($expression, Utils::array_except(get_defined_vars(), array('__data', '__path'))); ?>";
	}

	/**
	 * Compile the each statements into valid PHP.
	 *
	 * @param type $expression each.
	 * @return string
	 */
	protected function compileEach( $expression ) {
		return "<?php echo \$__env->renderEach{$expression}; ?>";
	}

	/**
	 * Compile the unless statements into valid PHP.
	 *
	 * @param type $expression if.
	 * @return string
	 */
	protected function compileUnless( $expression ) {
		return "<?php if(!$expression): ?>";
	}

	/**
	 * Compile the end unless statements into valid PHP.
	 *
	 * @param type $expression endif.
	 * @return string
	 */
	protected function compileEndunless( $expression ) {
		return '<?php endif; ?>';
	}

	/**
	 * Compile the else statements into valid PHP.
	 *
	 * @param type $expression else.
	 * @return string
	 */
	protected function compileElse( $expression ) {
		return '<?php else: ?>';
	}

	/**
	 * Compile the for statements into valid PHP.
	 *
	 * @param type $expression for.
	 * @return string
	 */
	protected function compileFor( $expression ) {
		return "<?php for{$expression}: ?>";
	}

	/**
	 * Compile the foreach statements into valid PHP.
	 *
	 * @param type $expression foreach.
	 * @return string
	 */
	protected function compileForeach( $expression ) {
		return "<?php foreach{$expression}: ?>";
	}

	/**
	 * Compile the if statements into valid PHP.
	 *
	 * @param type $expression if.
	 * @return string
	 */
	protected function compileIf( $expression ) {
		return "<?php if{$expression}: ?>";
	}

	/**
	 * Compile the else-if statements into valid PHP.
	 *
	 * @param type $expression elseif.
	 * @return string
	 */
	protected function compileElseif( $expression ) {
		return "<?php elseif{$expression}: ?>";
	}

	/**
	 * Compile the while statements into valid PHP.
	 *
	 * @param type $expression while.
	 * @return string
	 */
	protected function compileWhile( $expression ) {
		return "<?php while{$expression}: ?>";
	}

	/**
	 * Compile the end-while statements into valid PHP.
	 *
	 * @param type $expression endwhile.
	 * @return string
	 */
	protected function compileEndwhile( $expression ) {
		return '<?php endwhile; ?>';
	}

	/**
	 * Compile the end-for statements into valid PHP.
	 *
	 * @param type $expression endfor.
	 * @return string
	 */
	protected function compileEndfor( $expression ) {
		return '<?php endfor; ?>';
	}

	/**
	 * Compile the end-for-each statements into valid PHP.
	 *
	 * @param type $expression endforeach.
	 * @return string
	 */
	protected function compileEndforeach( $expression ) {
		return '<?php endforeach; ?>';
	}

	/**
	 * Compile the end-if statements into valid PHP.
	 *
	 * @param type $expression endif.
	 * @return string
	 */
	protected function compileEndif( $expression ) {
		return '<?php endif; ?>';
	}

	/**
	 * Compile the extends statements into valid PHP.
	 *
	 * @param type $expression include.
	 * @return string
	 */
	protected function compileExtends( $expression ) {
		if ( starts_with( $expression, '(' ) ) {
			$expression = substr( $expression, 1, -1 );
		}

		$data = "<?php echo \$__env->make($expression, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>";

		$this->footer[] = $data;

		return '';
	}

	/**
	 * Compile the loop statement into valid PHP.
	 *
	 * @param type $expression loop.
	 * @return string
	 */
	protected function compileLoop( $expression ) {
		return '<?php if(have_posts()){ while(have_posts()){ the_post(); ?>';
	}

	/**
	 * Compile the endloop statement into valid PHP.
	 *
	 * @param type $expression endloop.
	 * @return string
	 */
	protected function compileEndloop( $expression ) {
		return '<?php }} ?>';
	}

	/**
	 * Compile the query statement into valid PHP.
	 *
	 * @param type|WP_Query $expression query.
	 * @return string
	 */
	protected function compileQuery( $expression ) {
		return '<?php $themosisQuery = (is_array('.$expression.')) ? new WP_Query('.$expression.') : '.$expression.'; if($themosisQuery->have_posts()){ while($themosisQuery->have_posts()){ $themosisQuery->the_post(); ?>';
	}

	/**
	 * Compile the endquery statement into valid PHP.
	 *
	 * @param type $expression query end.
	 * @return string
	 */
	protected function compileEndquery( $expression ) {
		return '<?php }} wp_reset_postdata(); ?>';
	}

	/**
	 * Return the defined view content.
	 *
	 * @param type $path path to content view.
	 * @return string
	 */
	private function getViewContent( $path ) {
		if ( is_file( $path ) ) {
			return $this->wp_filesystem->get_contents( $path );
		}
		echo 'View file does not exists at this location: '.$path;
		die();
	}

	/**
	 * Minify our HTML code
	 * @param  [type] $buffer html.
	 * @return [type]         minifide html.
	 */
	public static function minify( $buffer ) {
		$search = array(
			'/\>[^\S ]+/s',  // strip whitespaces after tags, except space
			'/[^\S ]+\</s',  // strip whitespaces before tags, except space
			'/(\s)+/s'       // shorten multiple whitespace sequences
		);

		$replace = array(
			'>',
			'<',
			'\\1'
		);

		$buffer = preg_replace($search, $replace, $buffer);

		return $buffer;
	}
}