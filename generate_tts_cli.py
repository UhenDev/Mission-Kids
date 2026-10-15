import sys
import os
import hashlib
import asyncio
import edge_tts

VOICE = "id-ID-ArdiNeural"
RATE = "+5%"
PITCH = "+4Hz"
CACHE_DIR = r"c:\Users\HENDRIK WILDANSYAH\.gemini\antigravity-ide\scratch\mission-kids\public\audio\miko\cache"

async def main():
    if len(sys.argv) < 2:
        print("Usage: python generate_tts_cli.py <text>")
        sys.exit(1)

    text = sys.argv[1].strip()
    if not text:
        sys.exit(1)

    os.makedirs(CACHE_DIR, exist_ok=True)
    text_hash = hashlib.md5(text.encode('utf-8')).hexdigest()
    out_file = os.path.join(CACHE_DIR, f"{text_hash}.mp3")

    if not os.path.exists(out_file) or os.path.getsize(out_file) < 1000:
        communicate = edge_tts.Communicate(text, VOICE, rate=RATE, pitch=PITCH)
        await communicate.save(out_file)

    # Output relative URL
    print(f"/audio/miko/cache/{text_hash}.mp3")

if __name__ == "__main__":
    asyncio.run(main())
