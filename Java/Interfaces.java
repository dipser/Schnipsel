// Interfaces: Sammlung von Methodenrümpfen
// (Mehrfachvererbung ist nicht möglich in Java => Interfaces stattdessen)
interface FlaechigesObjekt {
	abstract public double flaeche();
}


abstract class GeometrischesObjekt {
	int x;
	int y;
	
	public GeometrischesObjekt(int x, int y) {
		super();
		this.x = x;
		this.y = y;
	}
	
	public abstract void draw(); // Abstrakte Methode muss implementiert werden.
}

class Rechteck extends GeometrischesObjekt implements FlaechigesObjekt {
	int width;
	int height;
	
	public Rechteck(int x, int y, int width, int height) {
		super(x, y);
		this.width = width;
		this.height = height;
	}

	public double flaeche() {
		return width * height;
	}
	
	public void draw() {}
	
	// Verhindern von ähnlichen Bezeichnungen (gross-/kleinschreibung)
	//@Override
	//public void Draw() {}
	
	public String toString() {
		return "Rechteck mit Massen "+width+" x "+height; 
	}
}

class Kreis extends GeometrischesObjekt implements FlaechigesObjekt {
	int radius;

	public Kreis(int x, int y, int radius) {
		super(x, y);
		this.radius = radius;
	}
	
	@Override
	public double flaeche() {
		return radius * radius*Math.PI;
	}
	
	public void draw() {}
	
	public String toString() {
		return "Kreis mit Radius "+radius; 
	}
}

class Linie extends GeometrischesObjekt {
	int radius;

	public Linie(int x, int y, int x2, int y2) {
		super(x, y);
	}
	
	public void draw() {}
	
	public String toString() {
		return "Linie "; 
	}
}



public class Test {
	
	public static void main(String[] args) {
		
		GeometrischesObjekt[] objekte = {
			new Rechteck(10, 10, 400, 200),
			new Rechteck(10, 10, 100, 300),
			new Rechteck(10, 10, 30, 40),
			new Linie(10, 10, 30, 40)
		};
		
		for (GeometrischesObjekt o : objekte) {
			System.out.println(o);
			if (o instanceof Kreis) {
				System.out.println("Kreis!");
			}
			if (o instanceof FlaechigesObjekt) {
				FlaechigesObjekt f = (FlaechigesObjekt) o;
				System.out.println(f.flaeche());
			}
		}
		
		
		Rechteck r = new Rechteck(10, 10, 400, 300);
		Kreis k = new Kreis(50, 50, 30);
		
		// Folgendes geht nicht da "abstract": (Verhalten wird vordefiniert in "abstract")
		//GeometrischesObjekt g = new GeometrischesObjekt(40, 40);
		
		System.out.println(r);
		System.out.println(k);
	}

}
