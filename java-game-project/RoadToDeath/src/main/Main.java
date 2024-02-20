package main;

import javax.swing.JFrame;

public class Main {

    public static void main(String[] args){

        JFrame window = new JFrame();
        //Lets the window close when user clicks on ("x")
        window.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        //Cannot resize the window
        window.setResizable(false);
        //Set the title name
        window.setTitle("RoadToDeath");

        GamePanel gamePanel = new GamePanel();
        window.add(gamePanel);

        //Set the size with the preferred size the gamePanel
        window.pack();

        //Window will be displayed at the middle of the window
        window.setLocationRelativeTo(null);
        //Be able to see the window
        window.setVisible(true);

        //Start the game loop
        gamePanel.setupGame();
        gamePanel.startGameThread();


    }

}
