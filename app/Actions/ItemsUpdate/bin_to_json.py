import struct
import json
import sys
from pathlib import Path

class DataReader:
    def __init__(self, raw_bytes):
        self.raw = raw_bytes
        self.offset = 0
        self.length = len(raw_bytes)

    def read_varint(self):
        value = 0
        for i in range(0, 32, 7):
            b = self.read_byte()
            value |= (b & 0b01111111) << i
            if not (b & 0b10000000):
                return value
        raise Exception("Too much data")

    def read_uint(self):
        val = struct.unpack_from('<I', self.raw, self.offset)[0]
        self.offset += 4
        return val

    def read_biguint(self):
        val = struct.unpack_from('<Q', self.raw, self.offset)[0]
        self.offset += 8
        return val

    def read_byte(self):
        val = self.raw[self.offset]
        self.offset += 1
        return val

    def read_bytes(self, n):
        val = self.raw[self.offset:self.offset + n]
        self.offset += n
        return val

class BinTextParser:
    @staticmethod
    def read_text_at(cursor, reader):
        before = reader.offset
        reader.offset = cursor
        length = reader.read_varint()
        value = reader.read_bytes(length)
        reader.offset = before
        return value.decode('utf-8')

    @staticmethod
    def parse(filepath):
        with open(filepath, 'rb') as f:
            buffer = f.read()

        reader = DataReader(buffer)
        lang_size = reader.read_byte()
        _ = reader.read_bytes(lang_size)  # language bytes not used

        result = {}

        nb_entries = reader.read_uint()
        for _ in range(nb_entries):
            entry_id = reader.read_uint()
            cursor = reader.read_uint()
            text = BinTextParser.read_text_at(cursor, reader)
            result[entry_id] = text

        ui_entries = reader.read_uint()
        for _ in range(ui_entries):
            entry_id = reader.read_biguint()
            cursor = reader.read_uint()
            text = BinTextParser.read_text_at(cursor, reader)
            result[int(entry_id)] = text

        return result

def main():
    if len(sys.argv) != 3:
        print("Usage: python bin_to_json.py <input_file.bin> <output_directory>")
        return

    input_path = Path(sys.argv[1])
    output_dir = Path(sys.argv[2])
    output_dir.mkdir(parents=True, exist_ok=True)

    result = BinTextParser.parse(input_path)
    output_path = output_dir / (input_path.stem + '.json')

    with open(output_path, 'w', encoding='utf-8') as f:
        json.dump(result, f, ensure_ascii=False, indent=2)

    print(f"Conversion réussie : {output_path}")

if __name__ == "__main__":
    main()
