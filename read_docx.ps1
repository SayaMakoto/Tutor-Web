$path = 'D:\PTTK\New Microsoft Word Document.docx'
Add-Type -AssemblyName System.IO.Compression.FileSystem
$z = [System.IO.Compression.ZipFile]::OpenRead($path)
$e = $z.GetEntry('word/document.xml')
$s = $e.Open()
$r = New-Object System.IO.StreamReader($s)
$xml = [xml]$r.ReadToEnd()
$r.Close()
$s.Close()
$z.Dispose()
$ns = New-Object System.Xml.XmlNamespaceManager($xml.NameTable)
$ns.AddNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main')
$xml.SelectNodes('//w:p', $ns) | ForEach-Object {
    $text = ''
    $_.SelectNodes('.//w:t', $ns) | ForEach-Object { $text += $_.InnerText }
    if ($text) { Write-Output $text }
}
