<?php
/**
 * Theme storage manipulations
 *
 * @package INESTIO
 * @since INESTIO 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

// Get theme variable
if ( ! function_exists( 'inestio_storage_get' ) ) {
	function inestio_storage_get( $var_name, $default = '' ) {
		global $INESTIO_STORAGE;
		return isset( $INESTIO_STORAGE[ $var_name ] ) ? $INESTIO_STORAGE[ $var_name ] : $default;
	}
}

// Set theme variable
if ( ! function_exists( 'inestio_storage_set' ) ) {
	function inestio_storage_set( $var_name, $value ) {
		global $INESTIO_STORAGE;
		$INESTIO_STORAGE[ $var_name ] = $value;
	}
}

// Check if theme variable is empty
if ( ! function_exists( 'inestio_storage_empty' ) ) {
	function inestio_storage_empty( $var_name, $key = '', $key2 = '' ) {
		global $INESTIO_STORAGE;
		if ( ! empty( $key ) && ! empty( $key2 ) ) {
			return empty( $INESTIO_STORAGE[ $var_name ][ $key ][ $key2 ] );
		} elseif ( ! empty( $key ) ) {
			return empty( $INESTIO_STORAGE[ $var_name ][ $key ] );
		} else {
			return empty( $INESTIO_STORAGE[ $var_name ] );
		}
	}
}

// Check if theme variable is set
if ( ! function_exists( 'inestio_storage_isset' ) ) {
	function inestio_storage_isset( $var_name, $key = '', $key2 = '' ) {
		global $INESTIO_STORAGE;
		if ( ! empty( $key ) && ! empty( $key2 ) ) {
			return isset( $INESTIO_STORAGE[ $var_name ][ $key ][ $key2 ] );
		} elseif ( ! empty( $key ) ) {
			return isset( $INESTIO_STORAGE[ $var_name ][ $key ] );
		} else {
			return isset( $INESTIO_STORAGE[ $var_name ] );
		}
	}
}

// Delete theme variable
if ( ! function_exists( 'inestio_storage_unset' ) ) {
	function inestio_storage_unset( $var_name, $key = '', $key2 = '' ) {
		global $INESTIO_STORAGE;
		if ( ! empty( $key ) && ! empty( $key2 ) ) {
			unset( $INESTIO_STORAGE[ $var_name ][ $key ][ $key2 ] );
		} elseif ( ! empty( $key ) ) {
			unset( $INESTIO_STORAGE[ $var_name ][ $key ] );
		} else {
			unset( $INESTIO_STORAGE[ $var_name ] );
		}
	}
}

// Inc/Dec theme variable with specified value
if ( ! function_exists( 'inestio_storage_inc' ) ) {
	function inestio_storage_inc( $var_name, $value = 1 ) {
		global $INESTIO_STORAGE;
		if ( empty( $INESTIO_STORAGE[ $var_name ] ) ) {
			$INESTIO_STORAGE[ $var_name ] = 0;
		}
		$INESTIO_STORAGE[ $var_name ] += $value;
	}
}

// Concatenate theme variable with specified value
if ( ! function_exists( 'inestio_storage_concat' ) ) {
	function inestio_storage_concat( $var_name, $value ) {
		global $INESTIO_STORAGE;
		if ( empty( $INESTIO_STORAGE[ $var_name ] ) ) {
			$INESTIO_STORAGE[ $var_name ] = '';
		}
		$INESTIO_STORAGE[ $var_name ] .= $value;
	}
}

// Get array (one or two dim) element
if ( ! function_exists( 'inestio_storage_get_array' ) ) {
	function inestio_storage_get_array( $var_name, $key, $key2 = '', $default = '' ) {
		global $INESTIO_STORAGE;
		if ( empty( $key2 ) ) {
			return ! empty( $var_name ) && ! empty( $key ) && isset( $INESTIO_STORAGE[ $var_name ][ $key ] ) ? $INESTIO_STORAGE[ $var_name ][ $key ] : $default;
		} else {
			return ! empty( $var_name ) && ! empty( $key ) && isset( $INESTIO_STORAGE[ $var_name ][ $key ][ $key2 ] ) ? $INESTIO_STORAGE[ $var_name ][ $key ][ $key2 ] : $default;
		}
	}
}

// Set array element
if ( ! function_exists( 'inestio_storage_set_array' ) ) {
	function inestio_storage_set_array( $var_name, $key, $value ) {
		global $INESTIO_STORAGE;
		if ( ! isset( $INESTIO_STORAGE[ $var_name ] ) ) {
			$INESTIO_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			$INESTIO_STORAGE[ $var_name ][] = $value;
		} else {
			$INESTIO_STORAGE[ $var_name ][ $key ] = $value;
		}
	}
}

// Set two-dim array element
if ( ! function_exists( 'inestio_storage_set_array2' ) ) {
	function inestio_storage_set_array2( $var_name, $key, $key2, $value ) {
		global $INESTIO_STORAGE;
		if ( ! isset( $INESTIO_STORAGE[ $var_name ] ) ) {
			$INESTIO_STORAGE[ $var_name ] = array();
		}
		if ( ! isset( $INESTIO_STORAGE[ $var_name ][ $key ] ) ) {
			$INESTIO_STORAGE[ $var_name ][ $key ] = array();
		}
		if ( '' === $key2 ) {
			$INESTIO_STORAGE[ $var_name ][ $key ][] = $value;
		} else {
			$INESTIO_STORAGE[ $var_name ][ $key ][ $key2 ] = $value;
		}
	}
}

// Merge array elements
if ( ! function_exists( 'inestio_storage_merge_array' ) ) {
	function inestio_storage_merge_array( $var_name, $key, $value ) {
		global $INESTIO_STORAGE;
		if ( ! isset( $INESTIO_STORAGE[ $var_name ] ) ) {
			$INESTIO_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			$INESTIO_STORAGE[ $var_name ] = array_merge( $INESTIO_STORAGE[ $var_name ], $value );
		} else {
			$INESTIO_STORAGE[ $var_name ][ $key ] = array_merge( $INESTIO_STORAGE[ $var_name ][ $key ], $value );
		}
	}
}

// Add array element after the key
if ( ! function_exists( 'inestio_storage_set_array_after' ) ) {
	function inestio_storage_set_array_after( $var_name, $after, $key, $value = '' ) {
		global $INESTIO_STORAGE;
		if ( ! isset( $INESTIO_STORAGE[ $var_name ] ) ) {
			$INESTIO_STORAGE[ $var_name ] = array();
		}
		if ( is_array( $key ) ) {
			inestio_array_insert_after( $INESTIO_STORAGE[ $var_name ], $after, $key );
		} else {
			inestio_array_insert_after( $INESTIO_STORAGE[ $var_name ], $after, array( $key => $value ) );
		}
	}
}

// Add array element before the key
if ( ! function_exists( 'inestio_storage_set_array_before' ) ) {
	function inestio_storage_set_array_before( $var_name, $before, $key, $value = '' ) {
		global $INESTIO_STORAGE;
		if ( ! isset( $INESTIO_STORAGE[ $var_name ] ) ) {
			$INESTIO_STORAGE[ $var_name ] = array();
		}
		if ( is_array( $key ) ) {
			inestio_array_insert_before( $INESTIO_STORAGE[ $var_name ], $before, $key );
		} else {
			inestio_array_insert_before( $INESTIO_STORAGE[ $var_name ], $before, array( $key => $value ) );
		}
	}
}

// Push element into array
if ( ! function_exists( 'inestio_storage_push_array' ) ) {
	function inestio_storage_push_array( $var_name, $key, $value ) {
		global $INESTIO_STORAGE;
		if ( ! isset( $INESTIO_STORAGE[ $var_name ] ) ) {
			$INESTIO_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			array_push( $INESTIO_STORAGE[ $var_name ], $value );
		} else {
			if ( ! isset( $INESTIO_STORAGE[ $var_name ][ $key ] ) ) {
				$INESTIO_STORAGE[ $var_name ][ $key ] = array();
			}
			array_push( $INESTIO_STORAGE[ $var_name ][ $key ], $value );
		}
	}
}

// Pop element from array
if ( ! function_exists( 'inestio_storage_pop_array' ) ) {
	function inestio_storage_pop_array( $var_name, $key = '', $defa = '' ) {
		global $INESTIO_STORAGE;
		$rez = $defa;
		if ( '' === $key ) {
			if ( isset( $INESTIO_STORAGE[ $var_name ] ) && is_array( $INESTIO_STORAGE[ $var_name ] ) && count( $INESTIO_STORAGE[ $var_name ] ) > 0 ) {
				$rez = array_pop( $INESTIO_STORAGE[ $var_name ] );
			}
		} else {
			if ( isset( $INESTIO_STORAGE[ $var_name ][ $key ] ) && is_array( $INESTIO_STORAGE[ $var_name ][ $key ] ) && count( $INESTIO_STORAGE[ $var_name ][ $key ] ) > 0 ) {
				$rez = array_pop( $INESTIO_STORAGE[ $var_name ][ $key ] );
			}
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if ( ! function_exists( 'inestio_storage_inc_array' ) ) {
	function inestio_storage_inc_array( $var_name, $key, $value = 1 ) {
		global $INESTIO_STORAGE;
		if ( ! isset( $INESTIO_STORAGE[ $var_name ] ) ) {
			$INESTIO_STORAGE[ $var_name ] = array();
		}
		if ( empty( $INESTIO_STORAGE[ $var_name ][ $key ] ) ) {
			$INESTIO_STORAGE[ $var_name ][ $key ] = 0;
		}
		$INESTIO_STORAGE[ $var_name ][ $key ] += $value;
	}
}

// Concatenate array element with specified value
if ( ! function_exists( 'inestio_storage_concat_array' ) ) {
	function inestio_storage_concat_array( $var_name, $key, $value ) {
		global $INESTIO_STORAGE;
		if ( ! isset( $INESTIO_STORAGE[ $var_name ] ) ) {
			$INESTIO_STORAGE[ $var_name ] = array();
		}
		if ( empty( $INESTIO_STORAGE[ $var_name ][ $key ] ) ) {
			$INESTIO_STORAGE[ $var_name ][ $key ] = '';
		}
		$INESTIO_STORAGE[ $var_name ][ $key ] .= $value;
	}
}

// Call object's method
if ( ! function_exists( 'inestio_storage_call_obj_method' ) ) {
	function inestio_storage_call_obj_method( $var_name, $method, $param = null ) {
		global $INESTIO_STORAGE;
		if ( null === $param ) {
			return ! empty( $var_name ) && ! empty( $method ) && isset( $INESTIO_STORAGE[ $var_name ] ) ? $INESTIO_STORAGE[ $var_name ]->$method() : '';
		} else {
			return ! empty( $var_name ) && ! empty( $method ) && isset( $INESTIO_STORAGE[ $var_name ] ) ? $INESTIO_STORAGE[ $var_name ]->$method( $param ) : '';
		}
	}
}

// Get object's property
if ( ! function_exists( 'inestio_storage_get_obj_property' ) ) {
	function inestio_storage_get_obj_property( $var_name, $prop, $default = '' ) {
		global $INESTIO_STORAGE;
		return ! empty( $var_name ) && ! empty( $prop ) && isset( $INESTIO_STORAGE[ $var_name ]->$prop ) ? $INESTIO_STORAGE[ $var_name ]->$prop : $default;
	}
}
