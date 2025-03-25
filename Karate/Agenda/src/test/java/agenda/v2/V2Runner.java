package agenda.v2;

import com.intuit.karate.junit5.Karate;
import net.masterthought.cucumber.Configuration;
import net.masterthought.cucumber.ReportBuilder;

import java.io.File;
import java.util.Collections;

public class V2Runner {

    @Karate.Test
    Karate testAll() {
        return Karate.run("src/test/java/agenda/v2/");
    }

    static void generateReport(String karateOutputPath) {
        File reportDir = new File(karateOutputPath);
        Configuration config = new Configuration(reportDir, "Karate API Tests");
        ReportBuilder reportBuilder = new ReportBuilder(Collections.singletonList(karateOutputPath + "/karate-summary.json"), config);
        reportBuilder.generateReports();
    }
}
