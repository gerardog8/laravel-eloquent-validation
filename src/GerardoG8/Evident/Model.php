<?php namespace GerardoG8\Evident;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Input;
use Validator;

class Model extends Eloquent {
	protected $errors;
	protected static $auto_validate = true;
	protected static $rules = array();
	protected static $messages = array();

	protected static function boot() {
		parent::boot();

		if (static::$auto_validate) {
			static::saving(function($model) {
				return $model->validate();
			});
		}
	}

	public function validate($data = null) {
		if (!$data) {
			$data = $this->attributes;
		}

		$validation = Validator::make($data, static::$rules, static::$messages);

		if ($validation->passes()) {
			return true;
		}

		$this->errors = $validation->getMessageBag();

		return false;
	}

	public static function setMessages($messages) {
		static::$messages = $messages;
	}

	public static function getRules() {
		return static::$rules;
	}

	public static function getInput() {
		return Input::only(array_keys(static::$rules));
	}

	public function getErrorBag() {
		return $this->errors;
	}

	public function getErrors() {
		return $this->errors ? $this->errors->toArray() : array();
	}

	public function hasErrors() {
		return !empty($this->getErrors());
	}

	public function hasError($field) {
		return !$this->errors ? null : $this->errors->has($field);
	}

	public function getError($field) {
		return !$this->errors ? null : $this->errors->first($field);
	}
}
