// caesar-cipher.c
//
// This program brute-force decrypts Latin-alphabet ciphertexts using the Caesar Cipher.

/**
 * Full name: George Constantine Fotopoulos
 * R.N.: 1117202200234
 */

#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include <string.h>

// --- MACROS ---

#define ALPHABET_COUNT 26
#define FIRST_SHIFT_VALUE 1
#define LAST_SHIFT_VALUE  25

// --- ENUMS ---

/* Purely semantic */
enum ArgumentParsing {
  NO_CIPHERTEXT_GIVEN = 1,
  USER_GAVE_CIPHERTEXT = 2
};

// --- FUNCTIONS ---

// ----- ARGUMENT PARSING -----

/**
 * @brief Selects which ciphertext the program should process.
 *
 * If the user provides a ciphertext as a program argument, this value is used;
 * otherwise, the program falls back to the default ciphertext defined in the instructions.
 *
 * @param argc The total number of command-line arguments.
 * @param argv The array of the command-line argument strings.
 *
 * @param default_ciphertext The fallback ciphertext used when no argument is given by the user.
 *
 * @return A pointer to the selected ciphertext string.
 *
 * @note The program terminates with 'EXIT_FAILURE' if the argument count is invalid.
 */
static const char* ParseCiphertext(int argc, char* argv[], const char* default_ciphertext) {  
  switch (argc) {
    case NO_CIPHERTEXT_GIVEN: {
      return default_ciphertext;
    }

    case USER_GAVE_CIPHERTEXT: {
      return argv[1];
    }

    default: {
      fprintf(stderr, "[Error] Usage: %s [ciphertext]\n", argv[0]);
      exit(EXIT_FAILURE);
    }
  }
}

// ----- STRING HELPERS -----

/**
 * @brief Checks whether a character is an uppercase Latin letter.
 *
 * @param character The character to check.
 *
 * @return true if the character is between 'A' and 'Z', otherwise false.
 */
static inline bool IsUppercaseLetter(const char character) {
  return character >= 'A' && character <= 'Z';
}

/**
 * @brief Checks whether a character is a lowercase Latin letter.
 *
 * @param character The character to check.
 *
 * @return true if the character is between 'a' and 'z', otherwise false.
 */
static inline bool IsLowercaseLetter(const char character) {
  return character >= 'a' && character <= 'z';
}

// ----- CAESAR DECRYPTION -----

/**
 * @brief Decrypts a ciphertext using a specified Caesar shift value.
 *
 * Each alphabetic character is shifted backward by the given amount.
 * Non-alphabetic characters, such as spaces and punctuation marks, remain unchanged.
 *
 * @param ciphertext The encrypted input text.
 * @param shift_value The Caesar shift value used for decryption.
 * @param decrypted_text The output buffer where the decrypted text is stored.
 *
 * @note The caller must ensure that the 'decrypted_text' is large enough to store
 *       the full decrypted text + the terminating null character ('\0').
 */
static void DecryptCaesar(const char* ciphertext, int shift_value, char* decrypted_text) {
  size_t ciphertext_length = strlen(ciphertext);

  for (size_t index = 0; index < ciphertext_length; ++index) {
    char current_character = ciphertext[index];

    if (IsUppercaseLetter(current_character)) {
      int alphabet_index  = current_character - 'A';
      int decrypted_index = (alphabet_index - shift_value + ALPHABET_COUNT) % ALPHABET_COUNT;

      decrypted_text[index] = (char)('A' + decrypted_index);
    } else if (IsLowercaseLetter(current_character)) {
      int alphabet_index  = current_character - 'a';
      int decrypted_index = (alphabet_index - shift_value + ALPHABET_COUNT) % ALPHABET_COUNT;

      decrypted_text[index] = (char)('a' + decrypted_index);
    } else {
      decrypted_text[index] = current_character;
    }
  }

  decrypted_text[ciphertext_length] = '\0';
}

/**
 * @brief Tries all the possible Caesar shift values and prints each candidate's plaintext.
 *
 * @param ciphertext The encrypted text to brute-force.
 *
 * @note The program terminates with 'EXIT_FAILURE' if the memory allocation fails.
 */
static void BruteforceCaesar(const char* ciphertext) {
  size_t ciphertext_length = strlen(ciphertext);

  char* decrypted_text = malloc(ciphertext_length + 1);
  if (decrypted_text == NULL) {
    fprintf(stderr, "[Error] Failed to allocate memory for 'decrypted_text'.\n");
    exit(EXIT_FAILURE);
  }

  for (int shift_value = FIRST_SHIFT_VALUE; shift_value <= LAST_SHIFT_VALUE; ++shift_value) {
    DecryptCaesar(ciphertext, shift_value, decrypted_text);
    fprintf(stdout, "k = %2d -> %s\n", shift_value, decrypted_text);
  }

  free(decrypted_text);
}


// --- MAIN ---

int main(int argc, char* argv[]) {
  const char* default_ciphertext = "GUR NGGNPX JVYY OR YNHAPURQ GBZBEEBJ NG ZVQAVTUG";

  const char* selected_ciphertext = ParseCiphertext(argc, argv, default_ciphertext);
  BruteforceCaesar(selected_ciphertext);

  return EXIT_SUCCESS;
}
