import os
import re
import shutil
import subprocess

EDGE_PATH = r"C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe"
BASE_DIR = r"c:\Users\HENDRIK WILDANSYAH\.gemini\antigravity-ide\scratch\mission-kids"
OUTPUT_DIR = os.path.join(BASE_DIR, "BERKAS_SETOR_LOMBA")

DOCS_DIR = os.path.join(OUTPUT_DIR, "1_DOCS_ACUAN_AI")
JURNAL_DIR = os.path.join(OUTPUT_DIR, "2_JURNAL_PROMPT")

os.makedirs(DOCS_DIR, exist_ok=True)
os.makedirs(JURNAL_DIR, exist_ok=True)

def simple_md_to_html(md_text, title="Document"):
    # Convert simple markdown elements to HTML
    lines = md_text.splitlines()
    html_lines = []
    in_code_block = False
    code_block_content = []
    in_table = False
    table_lines = []

    def flush_table():
        nonlocal in_table, table_lines
        if not table_lines:
            return ""
        html = '<table style="width:100%; border-collapse: collapse; margin: 16px 0;">\n'
        for idx, row in enumerate(table_lines):
            cols = [c.strip() for c in row.strip().strip('|').split('|')]
            if idx == 0:
                html += '  <thead><tr style="background:#f1f5f9;">\n'
                for col in cols:
                    html += f'    <th style="border:1px solid #cbd5e1; padding:8px 12px; text-align:left; font-weight:600;">{col}</th>\n'
                html += '  </tr></thead><tbody>\n'
            elif idx == 1 and all(set(c.strip()).issubset({'-', ':', ' '}) for c in cols):
                continue
            else:
                bg = "#ffffff" if idx % 2 == 0 else "#f8fafc"
                html += f'  <tr style="background:{bg};">\n'
                for col in cols:
                    html += f'    <td style="border:1px solid #cbd5e1; padding:8px 12px;">{col}</td>\n'
                html += '  </tr>\n'
        html += '</tbody></table>\n'
        table_lines = []
        in_table = False
        return html

    for line in lines:
        if line.strip().startswith('```'):
            if in_code_block:
                code_text = "\n".join(code_block_content)
                code_escaped = code_text.replace('&', '&amp;').replace('<', '&lt;').replace('>', '&gt;')
                html_lines.append(f'<pre style="background:#1e293b; color:#f8fafc; padding:14px; border-radius:8px; overflow-x:auto; font-size:12px; line-height:1.45;"><code>{code_escaped}</code></pre>')
                code_block_content = []
                in_code_block = False
            else:
                if in_table:
                    html_lines.append(flush_table())
                in_code_block = True
            continue

        if in_code_block:
            code_block_content.append(line)
            continue

        if line.strip().startswith('|') and line.strip().endswith('|'):
            in_table = True
            table_lines.append(line)
            continue
        elif in_table:
            html_lines.append(flush_table())

        stripped = line.strip()
        if not stripped:
            html_lines.append('<div style="height:10px;"></div>')
            continue

        # Headers
        if stripped.startswith('# '):
            html_lines.append(f'<h1 style="color:#1e1b4b; border-bottom:2px solid #8b5cf6; padding-bottom:8px; margin-top:24px; font-size:24px;">{stripped[2:]}</h1>')
        elif stripped.startswith('## '):
            html_lines.append(f'<h2 style="color:#312e81; border-bottom:1px solid #e2e8f0; padding-bottom:6px; margin-top:20px; font-size:19px;">{stripped[3:]}</h2>')
        elif stripped.startswith('### '):
            html_lines.append(f'<h3 style="color:#4338ca; margin-top:16px; font-size:16px;">{stripped[4:]}</h3>')
        elif stripped.startswith('#### '):
            html_lines.append(f'<h4 style="color:#4f46e5; margin-top:12px; font-size:14px;">{stripped[5:]}</h4>')
        elif stripped.startswith('---'):
            html_lines.append('<hr style="border:none; border-top:1px solid #e2e8f0; margin:16px 0;">')
        elif stripped.startswith('> '):
            quote_text = stripped[2:]
            html_lines.append(f'<blockquote style="border-left:4px solid #8b5cf6; background:#f5f3ff; margin:12px 0; padding:10px 16px; color:#4c1d95; font-style:italic;">{quote_text}</blockquote>')
        elif stripped.startswith('- ') or stripped.startswith('* '):
            item_text = stripped[2:]
            html_lines.append(f'<li style="margin-bottom:4px; line-height:1.5;">{item_text}</li>')
        else:
            html_lines.append(f'<p style="margin-bottom:8px; line-height:1.55; color:#334155;">{stripped}</p>')

    if in_table:
        html_lines.append(flush_table())

    content_html = "\n".join(html_lines)
    # Bold, italics, inline code
    content_html = re.sub(r'\*\*(.+?)\*\*', r'<strong>\1</strong>', content_html)
    content_html = re.sub(r'\*(.+?)\*', r'<em>\1</em>', content_html)
    content_html = re.sub(r'`([^`]+)`', r'<code style="background:#f1f5f9; padding:2px 6px; border-radius:4px; font-size:12px; color:#0f172a;">\1</code>', content_html)

    full_html = f"""<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>{title}</title>
<style>
  @page {{
    size: A4;
    margin: 18mm 16mm;
  }}
  body {{
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    font-size: 13px;
    color: #1e293b;
    margin: 0;
    padding: 0;
  }}
  table {{
    page-break-inside: avoid;
  }}
  h1, h2, h3, h4 {{
    page-break-after: avoid;
  }}
  pre {{
    page-break-inside: avoid;
  }}
</style>
</head>
<body>
{content_html}
</body>
</html>"""
    return full_html

def convert_md_to_pdf(md_file_path, pdf_file_path, title):
    with open(md_file_path, "r", encoding="utf-8") as f:
        md_text = f.read()

    html_content = simple_md_to_html(md_text, title)
    temp_html_path = pdf_file_path.replace(".pdf", "_temp.html")
    with open(temp_html_path, "w", encoding="utf-8") as f:
        f.write(html_content)

    cmd = [
        EDGE_PATH,
        "--headless=new",
        "--disable-gpu",
        "--no-pdf-header-footer",
        f"--print-to-pdf={pdf_file_path}",
        temp_html_path
    ]
    subprocess.run(cmd, check=True)
    if os.path.exists(temp_html_path):
        os.remove(temp_html_path)
    print(f"Generated: {pdf_file_path} (Size: {os.path.getsize(pdf_file_path)} bytes)")

# 1. Documents for Field 1: Docs Acuan AI (Up to 5 files)
files_for_field1 = [
    ("AI_AGENT_GUIDELINES.md", "01_AI_AGENT_GUIDELINES", "Panduan Utama Acuan AI Agent"),
    ("docs/01_PROJECT_OVERVIEW.md", "02_PROJECT_OVERVIEW", "Spesifikasi Proyek Mission Kids"),
    ("docs/02_PRD.md", "03_PRODUCT_REQUIREMENTS_DOCUMENT", "Product Requirements Document (PRD)"),
    ("docs/04_ARCHITECTURE.md", "04_ARSITEKTUR_SISTEM", "Arsitektur Sistem & Spesifikasi Teknologi"),
    ("DOKUMEN_LAPORAN_LOMBA.md", "05_DOKUMEN_LAPORAN_LOMBA", "Dokumen Laporan Proyek Lomba Mission Kids")
]

print("--- Generating Field 1: Docs Acuan AI ---")
for src_rel, dst_base, doc_title in files_for_field1:
    src_path = os.path.join(BASE_DIR, src_rel)
    dst_md = os.path.join(DOCS_DIR, f"{dst_base}.md")
    dst_pdf = os.path.join(DOCS_DIR, f"{dst_base}.pdf")
    shutil.copy2(src_path, dst_md)
    convert_md_to_pdf(src_path, dst_pdf, doc_title)

# 2. Documents for Field 2: Jurnal Prompt (1 file)
print("\n--- Generating Field 2: Jurnal Prompt ---")
jurnal_src = os.path.join(BASE_DIR, "JURNAL_PROMPT_TERKURASI.md")
jurnal_dst_md = os.path.join(JURNAL_DIR, "JURNAL_PROMPT_TERKURASI.md")
jurnal_dst_pdf = os.path.join(JURNAL_DIR, "JURNAL_PROMPT_TERKURASI.pdf")
shutil.copy2(jurnal_src, jurnal_dst_md)
convert_md_to_pdf(jurnal_src, jurnal_dst_pdf, "Jurnal 5 Prompt Terkurasi Mission Kids")

print("\nAll submission files generated successfully!")
