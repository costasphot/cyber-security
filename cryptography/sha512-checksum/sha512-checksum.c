// sha512-checksum.c
//
// This program compares two SHA-512 checksum hashes.

/**
 * Full name: George Constantine Fotopoulos
 * R.N.: 1117202200234
 */

#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include <string.h>

// --- STRUCTS ---

typedef struct DoubleHash {
  const char* first_hash;
  const char* second_hash;
} DoubleHash;

// --- FUNCTIONS ---

// ----- ARGUMENT PARSING & VALIDATION -----

/**
 * @brief Parses and validates the two SHA-512 checksum arguments.
 * 
 * @param argc The total number of command-line arguments.
 * @param argv The array of the command-line argument strings.
 * 
 * @return A 'DoubleHash' structure containing the two checksum strings.
 * 
 * @note The program terminates with 'EXIT_FAILURE' if the argument count is invalid.
 */
static DoubleHash ParseArguments(int argc, char* argv[]) {
  if (argc != 3) {
    fprintf(stderr, "[Error] Usage: %s [first hash] [second hash]\n", argv[0]);
    exit(EXIT_FAILURE);
  }
  
  return (DoubleHash){ .first_hash = argv[1], .second_hash = argv[2] };
}

// ----- HELPERS -----

/**
 * @brief Checks whether two null-terminated strings are exactly equal.
 * 
 * @param first_string The first string to compare.
 * @param second_string The second string to compare.
 * 
 * @return true if the two strings are exactly equal, otherwise false.
 */
bool AreStringsEqual(const char* first_string, const char* second_string) {
  return strlen(first_string) == strlen(second_string) &&
          strncmp(first_string, second_string, strlen(first_string)) == 0;
}

// ----- HASH KEYS COMPARISON LOGIC -----

/**
 * @brief Compares the two SHA-512 checksum hashes, and reports the result.
 * 
 * @param hashes_to_compare A pointer to the 'DoubleHash' structure containing the two checksum hashes to compare.
 * 
 * @note The program terminates with 'EXIT_FAILURE' if the two hashes differ.
 */
static void CompareSha512(const DoubleHash* hashes_to_compare) {
  if (!AreStringsEqual(hashes_to_compare->first_hash, hashes_to_compare->second_hash)) {
    fprintf(
        stderr,
        "[Error] The hashes provided are not equal:\n"
        "First hash:\t%s\n"
        "Second hash:\t%s\n",
        hashes_to_compare->first_hash, hashes_to_compare->second_hash
    );
    
    exit(EXIT_FAILURE);
  }

  fputs("The hashes provided are equal!\n", stdout);
}


// --- MAIN ---

int main(int argc, char* argv[]) {
  DoubleHash hashes_to_compare;

  hashes_to_compare = ParseArguments(argc, argv);

  CompareSha512(&hashes_to_compare);

  return EXIT_SUCCESS;
}
