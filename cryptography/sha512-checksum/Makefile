# Makefile for the SHA-512 Checksum program.
#
# Full name: George Constantine Fotopoulos
# R.N.: 1117202200234
#
# Builds the 'sha512-checksum' executable in both debug and release modes.
#
# <!> Warning: Targets must all begin with TABs; not double-spaces. <!>

# Configuration
CC       = gcc
TARGET   = sha512-checksum
BUILD    = build
OBJ_DIR  = $(BUILD)/obj
BIN_DIR  = $(BUILD)/bin
SRC      = sha512-checksum.c
FLAGFILE = .build_type  # Tracks the last build type used

OBJ_DEBUG   = $(OBJ_DIR)/debug_sha512-checksum.o
OBJ_RELEASE = $(OBJ_DIR)/release_sha512-checksum.o

CFLAGS_COMMON  = -Wall -Wextra -Wpedantic -Wshadow -Wconversion -Wstrict-prototypes -Werror -std=c11
CFLAGS_DEBUG   = $(CFLAGS_COMMON) -g -O1 -fsanitize=address -fsanitize=undefined
CFLAGS_RELEASE = $(CFLAGS_COMMON) -O2

# Default target
all: release

# Ensure build directories exist
DIR_CHECK:
	@mkdir -p $(OBJ_DIR) $(BIN_DIR)

# Automatic clean when switching between build types
maybe_clean:
	@if [ -f $(FLAGFILE) ]; then \
		last=$$(cat $(FLAGFILE)); \
		if [ "$$last" != "$(BUILD_TYPE)" ]; then \
			echo "Switching from $$last to $(BUILD_TYPE), cleaning..."; \
			$(MAKE) clean; \
		fi; \
	fi
	@echo "$(BUILD_TYPE)" > $(FLAGFILE)

# Debug build
debug: BUILD_TYPE=debug
debug: maybe_clean DIR_CHECK $(BIN_DIR)/$(TARGET)_debug

# Release build
release: BUILD_TYPE=release
release: maybe_clean DIR_CHECK $(BIN_DIR)/$(TARGET)_release

# Link binaries
$(BIN_DIR)/$(TARGET)_debug: $(OBJ_DEBUG)
	$(CC) $(CFLAGS_DEBUG) $(OBJ_DEBUG) -o $@

$(BIN_DIR)/$(TARGET)_release: $(OBJ_RELEASE)
	$(CC) $(CFLAGS_RELEASE) $(OBJ_RELEASE) -o $@

# Compile source file (.c -> .o) with matching flags
$(OBJ_DIR)/debug_sha512-checksum.o: $(SRC)
	$(CC) $(CFLAGS_DEBUG) -c $< -o $@

$(OBJ_DIR)/release_sha512-checksum.o: $(SRC)
	$(CC) $(CFLAGS_RELEASE) -c $< -o $@

# Run debug with user-given SHA-512 hashes
run-debug: debug
	@read -p "Enter first SHA-512 hash: " first_hash; \
	read -p "Enter second SHA-512 hash: " second_hash; \
	echo "Running debug build with the provided SHA-512 hashes..."; \
	./$(BIN_DIR)/$(TARGET)_debug "$$first_hash" "$$second_hash"

# Run release with user-given SHA-512 hashes
run-release: release
	@read -p "Enter first SHA-512 hash: " first_hash; \
	read -p "Enter second SHA-512 hash: " second_hash; \
	echo "Running release build with the provided SHA-512 hashes..."; \
	./$(BIN_DIR)/$(TARGET)_release "$$first_hash" "$$second_hash"

# Clean build output
clean:
	rm -rf $(BUILD) $(FLAGFILE)

# Help message
help:
	@echo "Available make commands:"
	@echo "  make debug        - Build with debug flags + sanitizers"
	@echo "  make release      - Build optimized release binary"
	@echo "  make run-debug    - Build + run debug version with two SHA-512 hash inputs"
	@echo "  make run-release  - Build + run release version with two SHA-512 hash inputs"
	@echo "  make clean        - Remove build files"
	@echo "  make help         - Show this message"

# Prevent Make from mistaking these as file targets
.PHONY: all debug release run-debug run-release clean maybe_clean DIR_CHECK help