#Flyweight (Fliegengewicht)

Das Entwurfsmuster (engl. Design Pattern) Fliegengewicht (engl. Flyweight) wird verwendet, wenn eine große Anzahl ähnlicher Objekte erstellt werden soll. Das Ziel ist die Reduzierung des Speicherverbrauchs, durch die Teilung der Informationen, statt neuer Objekte zu erstellen.

 

##Beispiel:

###Interface
```Java
// Flyweight
public interface LineFlyweight
{
    public Color getColor();
    public void draw(Point location);
}
```
 

###Implementierung
```Java
//ConcreteFlyweight
public class Line implements LineFlyweight
{
    private Color color;
    
    public Line(Color c)
    {
        color = c;
    }

    public Color getColor()
    {
        return color;
    }
    
    public void draw(Point location)
    {
        //draw the character on screen
    }

}
```

###Factory

```Java
//Flyweight factory
public class LineFlyweightFactory
{
    private List<LineFlyweight> pool;
    
    public LineFlyweightFactory()
    {
        pool = new ArrayList<LineFlyweight>();
    }
    
    public LineFlyweight getLine(Color c)
    {
        //check if we've already created a line with this color
        for(LineFlyweight line: pool)
        {
            if(line.getColor().equals(c))
            {
                return line;
            }
        }
        //if not, create one and save it to the pool
        LineFlyweight line = new Line(c);
        pool.add(line);
        return line;
    }

}
```

###Benutzung:
```Java
LineFlyweightFactory factory = new LineFlyweightFactory();
....
LineFlyweight line = factory.getLine(Color.RED);
LineFlyweight line2 = factory.getLine(Color.RED);

//can use the lines independently
line.draw(new Point(100, 100));
line2.draw(new Point(200, 100));
```
 

##Verwandte Muster

* Kompositum: Implementierung der Blätter eines Kompositums als Fliegengewichte
* Abstrakte Fabrik: Erzeugungsmuster für Fliegengewichte
* Dekorierer: zur Speicherung des extrinsischen Zustands