<?php

	namespace BaseCRM\ServerSide;

	class BaseEmail {
		public string $to;
		public string $from;
		public string $subject;
		public string $message;
		public string $headers;
		public string $attachments;

		public function __construct() {
			$this->from    = ( get_option( 'admin_email' ) ) ?: 'no-reply@' . $_SERVER['SERVER_NAME'];
			$this->headers = "From: " . $this->from . "\r\n";
			$this->headers .= "Reply-To: " . $this->from . "\r\n";
			$this->headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		}

		#region Getters and Setters
		/**
		 * @return string
		 */
		public function get_to(): string {
			return $this->to;
		}

		/**
		 * @param string $to
		 *
		 * @return BaseEmail
		 */
		public function set_to( string $to ): BaseEmail {
			$this->to = $to;

			return $this;
		}

		/**
		 * @return string
		 */
		public function get_from(): string {
			return $this->from;
		}

		/**
		 * @param string $from
		 *
		 * @return BaseEmail
		 */
		public function set_from( string $from ): BaseEmail {
			$this->from = $from;

			return $this;
		}

		/**
		 * @return string
		 */
		public function get_subject(): string {
			return $this->subject;
		}

		/**
		 * @param string $subject
		 *
		 * @return BaseEmail
		 */
		public function set_subject( string $subject ): BaseEmail {
			$this->subject = $subject;

			return $this;
		}

		/**
		 * @return string
		 */
		public function get_message(): string {
			return $this->message;
		}

		/**
		 * @param string $message
		 *
		 * @return BaseEmail
		 */
		public function set_message( string $message ): BaseEmail {
			$this->message = $message;

			return $this;
		}

		/**
		 * @return string
		 */
		public function get_headers(): string {
			return $this->headers;
		}

		/**
		 * @param string $headers
		 *
		 * @return BaseEmail
		 */
		public function set_headers( string $headers ): BaseEmail {
			$this->headers = $headers;

			return $this;
		}

		/**
		 * @return string
		 */
		public function get_attachments(): string {
			return $this->attachments;
		}

		/**
		 * @param string $attachments
		 *
		 * @return BaseEmail
		 */
		public function set_attachments( string $attachments ): BaseEmail {
			$this->attachments = $attachments;

			return $this;
		}
		#endregion

		#region Public Functions
		public function send(): bool {
			$required = [ 'to', 'from', 'subject', 'message', 'headers' ];
			foreach ( $required as $field ) {
				if ( empty( $this->$field ) ) {
					return false;
				}
			}

			$send_status = false;

			try {
				$send_status = wp_mail( $this->to, $this->subject, $this->message, $this->headers, $this->attachments );
				$error_message = <<<HEREDOC
`
					Attempting to send email via BaseCRM filter to wp_mail()
					if you're seeing this, the function didn't experience a critical error

					To: {$this->to}
					Subject: {$this->subject}
					Message: {$this->message}
					Headers: {$this->headers}
					Attachments: {$this->attachments}
				
HEREDOC;

				error_log( $error_message );
			} catch ( \Exception $e ) {
				error_log( $e->getMessage() );
			}

			return $send_status;
		}
		#endregion

	}