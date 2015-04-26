import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

import javax.swing.JFrame;
import javax.swing.JButton;


class MeinActionListener implements ActionListener {
	@Override
	public void actionPerformed(ActionEvent e) {
		System.out.println("clicked!");
	}
	
}



public class Test2 {
	
	public static void main(String[] args) {
		
		JFrame frame = new JFrame();
		frame.setSize(600, 400);
		frame.setDefaultCloseOperation(frame.EXIT_ON_CLOSE);
		frame.setLayout(null);
		
		final JButton button = new JButton("click me!");
		button.setBounds(10, 10, 150, 40);
		
		frame.add(button);
		// Eigener ActionListener:
		//button.addActionListener(new MeinActionListener());
		// Alternative Kurschreibweise:
		button.addActionListener(new ActionListener() {
			@Override
			public void actionPerformed(ActionEvent e) {
				// TODO Auto-generated method stub
				button.setText("Was clicked!"); // button muss final sein oder ähnlliches, damit er bestehen bleibt
			}
		});
		
		
		frame.setVisible(true);
	}

}
