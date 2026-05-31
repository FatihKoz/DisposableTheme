#!/usr/bin/env python3
"""
Script to apply icon replacements from replacements.json
Migrates from FontAwesome (fas fa-*) to Bootstrap Icons (bi bi-*)
"""

import json
from pathlib import Path

def apply_replacements():
    """Read replacements.json and apply all replacements"""

    # Read the replacements.json file
    replacements_file = Path(r"D:\Documents\GitHub\DisposableTheme\replacements.json")

    if not replacements_file.exists():
        print(f"Error: {replacements_file} not found!")
        return False

    with open(replacements_file, 'r', encoding='utf-8') as f:
        replacements = json.load(f)

    print(f"Found {len(replacements)} replacements to apply")
    print("=" * 80)

    # Track results
    successful = 0
    failed = 0
    not_found = 0
    fixed_paths = 0

    for replacement in replacements:
        file_path_str = replacement['filePath']

        # Fix path separators if needed
        file_path_str = file_path_str.replace('\\\\', '/')
        file_path = Path(file_path_str)

        old_string = replacement['oldString']
        new_string = replacement['newString']

        try:
            # Check if file exists
            if not file_path.exists():
                print(f"NOT FOUND: {file_path}")
                print(f"   File does not exist: {file_path_str}")
                not_found += 1
                continue

            # Read the file
            with open(file_path, 'r', encoding='utf-8') as f:
                content = f.read()

            # Check if the old string exists
            if old_string not in content:
                # Check if this is a path separator issue
                if not file_path_str.startswith('\\'):
                    # Try with Windows-style path
                    windows_path = file_path_str.replace('/', '\\\\')
                    windows_file_path = Path(windows_path)
                    if windows_file_path.exists():
                        if old_string not in windows_file_path.read_text(encoding='utf-8'):
                            print(f"NOT FOUND: {file_path}")
                            print(f"   Looking for: {old_string[:50]}...")
                            not_found += 1
                            continue

            # Apply the replacement
            content = content.replace(old_string, new_string)

            # Write back to file (UTF-8 with BOM for Windows compatibility)
            with open(file_path, 'w', encoding='utf-8', newline='') as f:
                f.write(content)

            successful += 1

        except Exception as e:
            print(f"ERROR processing {file_path}: {str(e)}")
            failed += 1

    print("=" * 80)
    print(f"Successful: {successful}")
    print(f"Not found: {not_found}")
    print(f"Failed: {failed}")
    print(f"Total: {successful + failed + not_found}")

    return successful > 0

if __name__ == "__main__":
    success = apply_replacements()
    exit(0 if success else 1)
