<?php
#==================================================
#	Cryptage et décryptage d'une valeur
#==================================================

      function cryptpass data, $key, $encrypt=true ) {

          # Serialize, if encryptings

          if ( $encrypt ) $data = serialize($data);

          # Open cipher module

          if ( ! $td = mcrypt_module_open('rijndael-256', '', 'cfb', '') )

              return false;

          $ks = mcrypt_enc_get_key_size($td);     # Required key size

          $key = substr(sha1($key), 0, $ks);      # Harden / adjust length

          $ivs = mcrypt_enc_get_iv_size($td);     # IV size

          $iv = $encrypt ?

              mcrypt_create_iv($ivs, MCRYPT_RAND) :   # Create IV, if encrypting

              substr($data, 0, $ivs);                 # Extract IV, if decrypting

          # Extract data, if decrypting

          if ( ! $encrypt ) $data = substr($data, $ivs);

          if ( mcrypt_generic_init($td, $key, $iv) !== 0 ) # Initialize buffers

              return false;

          $data = $encrypt ?

              mcrypt_generic($td, $data) :    # Perform encryption

              mdecrypt_generic($td, $data);   # Perform decryption

          if ( $encrypt ) $data = $iv . $data;    # Prepend IV, if encrypting

          mcrypt_generic_deinit($td);             # Clear buffers
          mcrypt_module_close($td);               # Close cipher module
		  
          # Unserialize, if decrypting
          if ( ! $encrypt ) $data= unserialize($data);
          return $data;
      }

?>