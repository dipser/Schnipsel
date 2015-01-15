Sub SaveCSV()

Dim Bereich As Object, Zeile As Object, Zelle As Object
Dim strTemp As String
Dim strDateiname As String
Dim strTrennzeichen As String
Dim strZeilenendezeichen As String
Dim strMappenpfad As String

strMappenpfad = ActiveWorkbook.FullName
strMappenpfad = Replace(strMappenpfad, ".xls", ".csv")

strDateiname = InputBox("Wie soll die CSV-Datei heißen (c:\test.csv)?", "CSV-Export", strMappenpfad)
If strDateiname = "" Then Exit Sub

strTrennzeichen = InputBox("Welches Trennzeichen soll verwendet werden?", "CSV-Export", ",")
If strTrennzeichen = "" Then Exit Sub

strZeilenendezeichen = InputBox("Welches Zeilenendezeichen soll verwendet werden?", "CSV-Export", ",")
If strZeilenendezeichen = "" Then Exit Sub

Set Bereich = ActiveSheet.UsedRange

Open strDateiname For Output As #1
For Each Zeile In Bereich.Rows
  For Each Zelle In Zeile.Cells
    strTemp = strTemp & "" & CStr(Zelle.Text) & "" & strTrennzeichen
  Next
  If Right(strTemp, 1) = strTrennzeichen Then strTemp = Left(strTemp, Len(strTemp) - 1)
  Print #1, strTemp & strZeilenendezeichen
  strTemp = ""
Next

Close #1
Set Bereich = Nothing
MsgBox "Export erfolgreich. Datei wurde exportiert nach" & vbCrLf & strDateiname
End Sub
