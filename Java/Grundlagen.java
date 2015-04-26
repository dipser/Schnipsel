// Präsenz 1

package pfw;


// Überladen ist ein Polymorphismus: Methode kann mit unterschiedlichen Parametern daherkommen

// Zeile nach oben oder unten verschieben: alt+pfeil

// Array wird begrenzt
// ArrayList wächst autom. mit (zugriff schnell / änderung aufwändig)
// LinkedList ist am flexibelsten (zugriff linear langsam / änderung schnell)

// Interfaces sind Klassen, wobei die leeren Methodenrümpfe ausdefiniert werden müssen
// class X implements Xyz {}



// Eine Klasse ist eine Schablone / Vorlage / Bauplan.
class Person {
	// public: kein zugriff von außen und bei vererbung
	// protected: kein zugriff von außen, aber bei vererbung
	// public: Zugriff erlaubt
	String name; // Objektvariable
	String vorname;
	public Person() {}
	public Person(String vorname, String name) {
		this.vorname = vorname;
		this.name = name;
	}
	public void begruessung() {
		System.out.println("Ich bin die Person"+vorname);
	}
	public String toString() {
		return "toString: "+vorname+" "+name;
	}

}

class Studierender extends Person {

	public Studierender(String vorname, String name) {
		// TODO Auto-generated constructor stub
		super(vorname, name); // Ruft Konstruktor von Person auf
		
		System.out.println(vorname);
	}
	
}



// Nur eine public-class pro Datei!
public class HelloWorld {
	
	// Kürzel: main + ctrl+leer	
	public static void main(String[] args) {

		int i = 1;
		System.out.println(i);
		
		//sysout + ctrl+leer
		
		String[] names = new String[10];
		names[0] = "asdf";
		for (String s : names) {
			System.out.println(s);
		}
		
		int[] zahlen;
		// Literalschreibweise:
		zahlen = new int[]{1,2,3,4,5,6,7};
		int[] zahlen2 = new int[]{1,2,3,4,5,6,7};
		
		String s = "Hallo";
		String s2 = "Hallo";
		System.out.println(s + s2);
		System.out.println(s == s2); // true => in der selben speicherstelle (Referenz)
		
		String str = new String("Hallo");
		String str2 = new String("Hallo");
		System.out.println(str + str2);
		System.out.println(str == str2); // false => nicht in der selben speicherstelle	
		System.out.println(str.equals(str2)); // true => Vergleich vom Inhalt	

		// Immutable: Objekte die nicht veränderbar sind.
		
		
		eingabe();
		verarbeitung();
		
		// Übergabe der Parameter:
		// Call-by-value <- Java
		// Call-by-reference
		
		
		Person p = new Person();
		p.name = "Hermand";
		p.vorname = "Aurel";
		p.begruessung();
		p.toString();
		
		Person p2 = new Person();
		p2.name = "Hermand";
		p2.vorname = "Aurel";
		
		System.out.println(p);
		
	}

	public static void eingabe() {
		System.out.println("Hallo bitte Daten eingeben");
	}
	
	private static void verarbeitung() {
		// TODO Auto-generated method stub
		
	}
	
	private static void test(int i, int j, int k) { // <- Signatur
		// TODO Auto-generated method stub
		
	}
	
	private static int sum(int i, int j, int k) { // <- Signatur
		// TODO Auto-generated method stub
		return i+j+k;
	}
	
}
