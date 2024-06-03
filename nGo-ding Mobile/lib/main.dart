import 'package:firebase_core/firebase_core.dart';
import 'package:flutter/material.dart';
import 'package:wmk/firebase_options.dart';
import 'package:wmk/screen/home_screen.dart';
import 'package:wmk/screen/introduction_screen.dart';
import 'package:wmk/screen/login_screen.dart';
import 'package:wmk/widgets/splash.dart';

void main() async {
  runApp(const MyApp());
  // Inisialisasi Firebase App
  WidgetsFlutterBinding.ensureInitialized(); // Tambahkan baris ini jika Anda mendapatkan pesan kesalahan di awal
  await Firebase.initializeApp(
    options: DefaultFirebaseOptions.currentPlatform,
  );
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      initialRoute: '/', // Set initialRoute to '/'
      routes: {
        '/': (context) => SplashScreenDelay(), // Use '/' as the initial route
        'home': (context) => HomeScreen(),
        'login': (context) => LoginScreen(),
        
      },
    );
  }
}

class SplashScreenDelay extends StatelessWidget {
  const SplashScreenDelay({super.key});

  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
      future: Future.delayed(const Duration(seconds: 4)),
      builder: (context, snapshot) {
        if (snapshot.connectionState == ConnectionState.waiting) {
          return const SplashScreen();
        } else {
          return const MyHomePage(
              title: 'Introduction'); // Ganti dengan halaman beranda Anda.
        }
      },
    );
  }
}
