package agenda.public_path;

import com.intuit.karate.junit5.Karate;

public class PublicPathRunner {
    @Karate.Test
    Karate testAll() {
        return Karate.run("src/test/java/agenda/public_path/");
    }
}
